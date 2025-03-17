<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento; // Certifique-se de importar a model

class AgendamentoController extends Controller
{
    // Mostrar o formulário de agendamento
    public function create()
    {
        return view('agendamento.create'); // Crie a view para o formulário de agendamento
    }

    // Salvar o agendamento
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'servico' => 'required|string',
        ]);

        // Verificar se o horário já está agendado
        $existeAgendamento = Agendamento::where('data', $request->data)
                                          ->where('hora', $request->hora)
                                          ->exists();

        if ($existeAgendamento) {
            return back()->with('erro', 'Este horário já está agendado. Por favor, escolha outro horário.');
        }

        // Criar o novo agendamento
        Agendamento::create([
            'nome_cliente' => $request->nome_cliente,
            'data' => $request->data,
            'hora' => $request->hora,
            'servico' => $request->servico,
        ]);

        return redirect()->route('admin.agendamento.create')->with('sucesso', 'Agendamento realizado com sucesso!');
    }

    // Exibir todos os agendamentos (para admins ou vendedores)
    public function index()
    {
        $agendamentos = Agendamento::all();
        return view('agendamento.index', compact('agendamentos'));
    }

    // Método para retornar os agendamentos em formato JSON
    public function getAgendamentos()
    {
        // Buscar todos os agendamentos no banco de dados
        $agendamentos = Agendamento::all();

        // Formatar os dados para o FullCalendar
        $events = $agendamentos->map(function($agendamento) {
            return [
                'title' => $agendamento->servico,
                'start' => $agendamento->data . 'T' . $agendamento->hora, // Concatenando data e hora
                'end' => $agendamento->data . 'T' . $agendamento->hora,   // Usando o mesmo horário para o "end"
                'description' => $agendamento->nome_cliente,  // Descrição (nome do cliente)
                'color' => '#ff0000'  // Cor para indicar que o horário está ocupado
            ];
        });

        // Retornar os agendamentos no formato JSON
        return response()->json($events);
    }
}
