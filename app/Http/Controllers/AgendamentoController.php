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
            '2025-01-01',
            '2025-04-18',
            '2025-04-20',
            '2025-04-25',
            '2025-05-01',
            '2025-06-10',
            '2025-08-15',
            '2025-10-05',
            '2025-11-01',
            '2025-12-01',
            '2025-12-08',
            '2025-12-25'
        ];
        if (in_array($request->data, $feriados)) {
            return back()->withErrors(['data' => 'Não é possível agendar para um feriado.']);
        }

        // Extrair a duração do serviço
        $duracao = explode('|', $request->servico)[1] ?? 1.0;

        // Criar o agendamento
        $agendamento = Agendamento::create([
            'nome_cliente' => $nomeCliente,
            'data' => $request->data,
            'hora' => $request->hora,
            'servico' => $request->servico,
            'duracao' => $duracao,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Combinar data e hora para scheduled_at
        $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', $request->data . ' ' . $request->hora, config('app.timezone'));

        // Criar automaticamente uma Order associada ao Agendamento
        Order::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(),
            'scheduled_at' => $scheduledAt, // Agora inclui data e hora
        ]);

        return redirect()->route('agendamento.index')
            ->with('success', 'Agendamento realizado com sucesso!')
            ->with('popup', true);
    }

    public function index()
    {
        $agendamentos = Agendamento::select('data', 'hora', 'servico', 'duracao', 'nome_cliente')->get();
        return view('agendamento.index', compact('agendamentos'));
    }

    public function getAgendamentos()
    {
        try {
            $agendamentos = Agendamento::select('data', 'hora', 'servico', 'duracao', 'nome_cliente')->get();

            $events = $agendamentos->map(function ($agendamento) {
                $start = Carbon::parse($agendamento->data . ' ' . $agendamento->hora);
                $end = $start->copy()->addHours((float)($agendamento->duracao ?? 1.0));

                if (!$start->isValid() || !$end->isValid()) {
                    return null;
                }

                return [
                    'title' => $agendamento->servico ?: 'Serviço não especificado',
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'description' => $agendamento->nome_cliente ?: 'Cliente não especificado',
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
