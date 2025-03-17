<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import necessário para usar DB::raw()
use App\Models\Agendamento;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    /**
     * Mostra o formulário de criação de agendamento com calendário.
     */
    public function create()
    {
        return view('agendamento.create');
    }

    /**
     * Salva um novo agendamento no banco de dados com validações avançadas.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'servico' => 'required|string',
        ]);

        // Extrair serviço e duração do campo (formato: "servico|duracao")
        [$servico, $duracao] = explode('|', $request->servico);

        // Criar data e hora com Carbon
        $dataHoraInicio = Carbon::parse($request->data . ' ' . $request->hora);
        $dataHoraFim = $dataHoraInicio->copy()->addHours($duracao);

        // Validação de horário laboral (9h-12h e 13h-19h em minutos)
        $horaInicio = $dataHoraInicio->hour * 60 + $dataHoraInicio->minute;
        $horaFim = $dataHoraFim->hour * 60 + $dataHoraFim->minute;
        $inicioManha = 9 * 60; // 9:00
        $fimManha = 12 * 60;   // 12:00
        $inicioTarde = 13 * 60; // 13:00
        $fimTarde = 19 * 60;   // 19:00

        if (
            ($horaInicio < $inicioManha || ($horaInicio >= $fimManha && $horaInicio < $inicioTarde) || $horaInicio >= $fimTarde) ||
            ($horaFim <= $fimManha && $horaFim > $inicioManha) || ($horaFim <= $fimTarde && $horaFim > $inicioTarde)
        ) {
            // Sugerir um horário alternativo (ex.: 10h)
            $sugestao = $dataHoraInicio->copy()->setTime(10, 0);
            return back()->with('error', "Horário fora do laboral (9h-12h ou 13h-19h). Sugere-se {$sugestao->format('H:i')} a {$sugestao->copy()->addHours($duracao)->format('H:i')}.");
        }

        // Verificar se é fim de semana
        $diaSemana = $dataHoraInicio->dayOfWeek;
        if ($diaSemana == 0 || $diaSemana == 6) {
            return back()->with('error', 'Agendamentos não permitidos aos fins de semana.');
        }

        // Verificar feriados (exemplo para 2025 - ajustar conforme necessário)
        $feriados = [
            '2025-01-01', // Ano Novo
            '2025-04-18', // Sexta-feira Santa
            '2025-04-20', // Páscoa
            '2025-04-25', // Dia da Liberdade
            '2025-05-01', // Dia do Trabalhador
            '2025-06-10', // Dia de Portugal
            '2025-08-15', // Assunção de Nossa Senhora
            '2025-10-05', // Implantação da República
            '2025-11-01', // Dia de Todos os Santos
            '2025-12-01', // Restauração da Independência
            '2025-12-08', // Imaculada Conceição
            '2025-12-25', // Natal
        ];
        if (in_array($request->data, $feriados)) {
            return back()->with('error', 'Agendamentos não permitidos em feriados.');
        }

        // Verificar dias de folga específicos (exemplo - ajustar conforme necessário)
        $folgas = ['2025-03-20', '2025-03-21']; // Adicione suas folgas
        if (in_array($request->data, $folgas)) {
            return back()->with('error', 'Agendamentos não permitidos nesse dia (folga).');
        }

        // Verificar se o horário já está ocupado, considerando a duração
        $existeAgendamento = Agendamento::where('data', $request->data)
            ->where(function ($query) use ($dataHoraInicio, $dataHoraFim) {
                $query->whereBetween('hora', [$dataHoraInicio->format('H:i'), $dataHoraFim->format('H:i')])
                    ->orWhereBetween(DB::raw('ADDTIME(hora, SEC_TO_TIME(duracao * 3600))'), [$dataHoraInicio->format('H:i'), $dataHoraFim->format('H:i')]);
            })
            ->exists();

        if ($existeAgendamento) {
            return back()->with('error', 'Este horário já está ocupado. Escolha outro horário.');
        }

        // Criar o novo agendamento
        Agendamento::create([
            'nome_cliente' => $request->nome_cliente,
            'data' => $request->data,
            'hora' => $request->hora,
            'servico' => $servico,
            'duracao' => $duracao, // Armazena a duração em horas
        ]);

        return redirect()->route('admin.agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Exibe a lista de agendamentos, filtrada por papel do usuário.
     */
    public function index()
    {
        $agendamentos = Auth::user()->role == 1
            ? Agendamento::where('nome_cliente', Auth::user()->name)->get()
            : Agendamento::all();

        return view('agendamento.index', compact('agendamentos'));
    }

    /**
     * Retorna os agendamentos em formato JSON para o FullCalendar.
     */
    public function getAgendamentos()
    {
        $agendamentos = Auth::user()->role == 1
            ? Agendamento::where('nome_cliente', Auth::user()->name)->get()
            : Agendamento::all();

        $events = $agendamentos->map(function ($agendamento) {
            $start = Carbon::parse($agendamento->data . ' ' . $agendamento->hora);
            $end = $start->copy()->addHours($agendamento->duracao ?? 1); // Usa 1 hora como padrão se duracao não existir

            return [
                'title' => $agendamento->servico,
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'description' => $agendamento->nome_cliente,
                'color' => '#ff0000',
            ];
        });

        return response()->json($events);
    }
}
