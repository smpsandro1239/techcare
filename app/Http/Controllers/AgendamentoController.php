<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
            'nome_cliente' => 'nullable|string|max:255', // Opcional para usuários não autenticados
        ]);

        // Usar o nome enviado pelo formulário ou um valor padrão se não autenticado
        $nomeCliente = $request->input('nome_cliente', 'Usuário Anônimo');

        // Verificar se a data é um feriado
        $feriados = [
            '2025-01-01', '2025-04-18', '2025-04-20', '2025-04-25', '2025-05-01',
            '2025-06-10', '2025-08-15', '2025-10-05', '2025-11-01', '2025-12-01',
            '2025-12-08', '2025-12-25'
        ];
        if (in_array($request->data, $feriados)) {
            return back()->withErrors(['data' => 'Não é possível agendar para um feriado.']);
        }

        // Extrair a duração do serviço
        $duracao = explode('|', $request->servico)[1] ?? 1.0;

        // Criar o agendamento
        Agendamento::create([
            'nome_cliente' => $nomeCliente,
            'data' => $request->data,
            'hora' => $request->hora,
            'servico' => $request->servico,
            'duracao' => $duracao,
            'created_at' => now(),
            'updated_at' => now(),
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
            // Carregar apenas os campos necessários
            $agendamentos = Agendamento::select('data', 'hora', 'servico', 'duracao', 'nome_cliente')->get();

            // Mapear os agendamentos para o formato que o FullCalendar entende
            $events = $agendamentos->map(function ($agendamento) {
                // Garantir que start e end sejam válidos
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
                    'color' => '#ff0000', // Cor do evento
                ];
            })->filter()->values(); // Reindexa e remove nulos

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Erro ao obter agendamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao carregar agendamentos'], 500);
        }
    }
}
