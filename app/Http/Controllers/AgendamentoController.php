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

        // Extrair a duração do serviço (ex.: "Instalação de Windows|2" -> 2)
        $duracao = explode('|', $request->servico)[1] ?? 1.0;

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
        $agendamentos = Agendamento::all();
        return view('agendamento.index', compact('agendamentos'));
    }

    public function getAgendamentos()
    {
        try {
            $agendamentos = Agendamento::all();

            $events = $agendamentos->map(function ($agendamento) {
                // Verificar se os campos necessários existem
                if (!$agendamento->data || !$agendamento->hora) {
                    return null; // Ignorar registros inválidos
                }

                $start = Carbon::parse($agendamento->data . ' ' . $agendamento->hora);
                $end = $start->copy()->addHours((float)($agendamento->duracao ?? 1.0));

                // Garantir que start e end sejam válidos
                if (!$start->isValid() || !$end->isValid()) {
                    return null; // Ignorar se as datas forem inválidas
                }

                return [
                    'title' => $agendamento->servico ?: 'Serviço não especificado',
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'description' => $agendamento->nome_cliente ?: 'Cliente não especificado',
                    'color' => '#ff0000',
                ];
            })->filter() // Remove null values
                ->values(); // Reindexa o array

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Erro ao obter agendamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao carregar agendamentos'], 500);
        }
    }
}
