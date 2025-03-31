<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User;

class CustomerMainController extends Controller
{
    /**
     * Exibe o perfil do cliente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('customer.profile');
    }

    /**
     * Exibe a página de pagamento do cliente.
     *
     * @return \Illuminate\View\View
     */
    public function payment()
    {
        return view('customer.payment');
    }

    /**
     * Exibe a página do programa de afiliados.
     *
     * @return \Illuminate\View\View
     */
    public function affiliate()
    {
        return view('customer.affiliate');
    }

    /**
     * Exibe os detalhes de um agendamento específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['user', 'agendamento']);
        return view('customer.order.show', compact('order'));
    }

    /**
     * Exibe o histórico de agendamentos do cliente.
     *
     * @return \Illuminate\View\View
     */
    public function order_history()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['agendamento'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);
        
        return view('customer.order.history', compact('orders'));
    }

    /**
     * Cancela um agendamento específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('user.order.history')
                ->with('error', 'Você não tem permissão para cancelar este agendamento.');
        }
        
        $order->delete();
        return redirect()->route('user.order.history')
            ->with('message', 'Agendamento cancelado com sucesso!');
    }
/**
     * Exibe o formulário para editar um agendamento específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        

        // Exibe o formulário de edição
        return view('customer.order.edit', compact('order'));
    }

    /**
     * Atualiza os dados de um agendamento específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {

        // Validação dos dados
        $request->validate([
            'scheduled_at' => 'required|date',
            // Adicione outras validações conforme necessário
        ]);

        // Atualiza o agendamento
        $order->update([
            'scheduled_at' => $request->input('scheduled_at'),
            // Atualize outros campos conforme necessário
        ]);

        return redirect()->route('user.order.history')
            ->with('message', 'Agendamento atualizado com sucesso!');
    }
    public function showReports($orderId)
    {
        // Verifica se o agendamento pertence ao cliente logado
        $order = Order::where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
        
        // Obtém os relatórios relacionados a esse agendamento
        $reports = $order->reports()->paginate(10);

        return view('customer.order.reports', compact('order', 'reports'));
    }
}

