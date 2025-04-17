<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function create()
    {
        return view('agendamento.create');
    }

    public function store(Request $request)
    {
        // Validar os dados, tornando nome_cliente opcional
        $request->validate([
            'data' => 'required|date',
            'hora' => 'required',
            'servico' => 'required',
            'nome_cliente' => 'nullable|string|max:255',
        ]);

        // Usar o nome enviado pelo formulário ou um valor padrão se não autenticado
        $nomeCliente = $request->input('nome_cliente', 'Usuário Anônimo');

        // Verificar se a data é um feriado
        $feriados = [
            '2025-01-01' => 'Ano Novo',
            '2025-04-18' => 'Sexta-feira Santa',
            '2025-04-20' => 'Páscoa',
            '2025-04-25' => 'Dia da Liberdade',
            '2025-05-01' => 'Dia do Trabalhador',
            '2025-06-10' => 'Dia de Portugal',
            '2025-08-15' => 'Assunção de Nossa Senhora',
            '2025-10-05' => 'Implantação da República',
            '2025-11-01' => 'Dia de Todos os Santos',
            '2025-12-01' => 'Restauração da Independência',
            '2025-12-08' => 'Imaculada Conceição',
            '2025-12-25' => 'Natal',
        ];

        if (array_key_exists($request->data, $feriados)) {
            return response()->json([
                'status' => 'error',
                'message' => "Não é possível agendar para o dia {$request->data}, pois é um feriado ({$feriados[$request->data]}). Por favor, escolha outra data."
            ], 422);
        }

        // Extrair a duração do serviço
        $duracao = explode('|', $request->servico)[1] ?? 1.0;

        // Combinar data e hora, interpretando como UTC (enviado pelo frontend)
        $scheduledAtUtc = Carbon::createFromFormat('Y-m-d H:i', $request->data . ' ' . $request->hora, 'UTC');

        // Converter para Europe/Lisbon para salvar em agendamento.hora
        $scheduledAtLocal = $scheduledAtUtc->copy()->setTimezone('Europe/Lisbon');

        // Criar o agendamento
        $agendamento = Agendamento::create([
            'nome_cliente' => $nomeCliente,
            'data' => $scheduledAtLocal->format('Y-m-d'),
            'hora' => $scheduledAtLocal->format('H:i'), // Salvar como Europe/Lisbon (ex.: 12:00)
            'servico' => $request->servico,
            'duracao' => $duracao,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Criar automaticamente uma Order associada ao Agendamento
        Order::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(),
            'scheduled_at' => $scheduledAtUtc, // Salvar em UTC (ex.: 2025-04-17 11:00:00)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Agendamento realizado com sucesso!',
            'redirect' => route('agendamento.index')
        ]);
    }

    public function index()
    {
        $agendamentos = Agendamento::select('data', 'hora', 'servico', 'duracao', 'nome_cliente')->paginate(4);
        return view('agendamento.index', compact('agendamentos'));
    }

    public function getAgendamentos()
    {
        try {
            $orders = Order::with('agendamento')->paginate(4);

            $events = $orders->map(function ($order) {
                $start = Carbon::parse($order->scheduled_at); // Já em UTC
                $end = $start->copy()->addHours((float)($order->agendamento->duracao ?? 1.0));

                if (!$start->isValid() || !$end->isValid()) {
                    return null;
                }

                return [
                    'title' => explode('|', $order->agendamento->servico)[0] ?: 'Serviço não especificado',
                    'start' => $start->toIso8601String(), // Enviar em UTC
                    'end' => $end->toIso8601String(),     // Enviar em UTC
                    'description' => $order->agendamento->nome_cliente ?: 'Cliente não especificado',
                    'color' => '#ff0000',
                ];
            })->filter()->values();

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Erro ao obter agendamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao carregar agendamentos'], 500);
        }
    }
}
