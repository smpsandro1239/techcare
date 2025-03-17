<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agendamento;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    public function create()
    {
        return view('agendamento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'servico' => 'required|string',
        ]);

        $existeAgendamento = Agendamento::where('data', $request->data)
            ->where('hora', $request->hora)
            ->exists();

        if ($existeAgendamento) {
            return back()->with('error', 'O horário selecionado já está ocupado. Escolha outro horário.');
        }

        Agendamento::create([
            'nome_cliente' => $request->nome_cliente,
            'data' => $request->data,
            'hora' => $request->hora,
            'servico' => $request->servico,
        ]);

        return redirect()->route('admin.agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    public function index()
    {
        $agendamentos = Auth::user()->role == 1
            ? Agendamento::where('nome_cliente', Auth::user()->name)->get()
            : Agendamento::all();

        return view('agendamento.index', compact('agendamentos'));
    }

    public function getAgendamentos()
    {
        $agendamentos = Auth::user()->role == 1
            ? Agendamento::where('nome_cliente', Auth::user()->name)->get()
            : Agendamento::all();

        $events = $agendamentos->map(function ($agendamento) {
            $start = Carbon::parse($agendamento->data . ' ' . $agendamento->hora);
            $end = $start->copy()->addHour();

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
