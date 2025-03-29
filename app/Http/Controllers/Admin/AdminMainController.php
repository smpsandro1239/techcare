<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User;

class AdminMainController extends Controller
{
    /**
     * Exibe o dashboard do administrador.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.admin');
    }

    /**
     * Exibe a página de configurações do administrador.
     *
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        return view('admin.settings');
    }

    /**
     * Exibe a página de gerenciamento de usuários.
     *
     * @return \Illuminate\View\View
     */
    public function manage_user()
    {
        return view('admin.manage.user');
    }

    /**
     * Exibe a página de gerenciamento de lojas.
     *
     * @return \Illuminate\View\View
     */
    public function manage_stores()
    {
        return view('admin.manage.store');
    }

    /**
     * Exibe o histórico de carrinhos.
     *
     * @return \Illuminate\View\View
     */
    public function cart_history()
    {
        return view('admin.cart.history');
    }

    /**
     * Exibe o histórico de agendamentos (ordens).
     *
     * @return \Illuminate\View\View
     */
    public function order_history()
    {
        $orders = Order::with(['user', 'agendamento'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);
        return view('admin.order.history', compact('orders'));
    }

    /**
     * Exibe os detalhes de um agendamento específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Carrega os relacionamentos para a view
        $order->load(['user', 'agendamento']);
        return view('admin.order.show', compact('order'));
    }

    /**
     * Deleta um agendamento específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.order.history')
            ->with('message', 'Agendamento deletado com sucesso!');
    }
}
