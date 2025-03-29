<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User;

class SellerMainController extends Controller
{
    /**
     * Exibe o painel de controle do vendedor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('seller.dashboard');
    }

    /**
     * Exibe o histórico de ordens do vendedor.
     *
     * @return \Illuminate\View\View
     */
    public function order_history()
    {
        // Aqui, provavelmente o vendedor verá ordens específicas relacionadas ao que ele está vendendo
        $orders = Order::where('user_id', auth()->id())  // A relação com o vendedor pode ser feita com 'seller_id'
            ->with(['user', 'agendamento'])  // Carrega as relações necessárias
            ->orderBy('scheduled_at', 'desc')  // Ordena pela data do agendamento
            ->paginate(10);  // Pagina os resultados

        return view('seller.order.history', compact('orders'));
    }

    /**
     * Exibe os detalhes de uma ordem específica.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Carrega os dados necessários para mostrar os detalhes da ordem
        $order->load(['user', 'agendamento']);
        return view('seller.order.show', compact('order'));
    }

    /**
     * Cancela uma ordem específica.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // Verifica se a ordem pertence ao vendedor atual
        if ($order->seller_id !== auth()->id()) {
            return redirect()->route('vendor.order.history')
                ->with('error', 'Você não tem permissão para cancelar esta ordem.');
        }

        $order->delete();
        return redirect()->route('seller.order.history')
            ->with('message', 'Ordem cancelada com sucesso!');
    }

    /**
     * Exibe o formulário para editar uma ordem específica.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        // Exibe o formulário de edição da ordem
        return view('seller.order.edit', compact('order'));
    }

    /**
     * Atualiza os dados de uma ordem específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        // Valida os dados antes de atualizar
        $request->validate([
            'scheduled_at' => 'required|date',  // Verifica se a data está no formato correto
            // Adicione outras validações conforme necessário
        ]);

        // Atualiza o agendamento da ordem
        $order->update([
            'scheduled_at' => $request->input('scheduled_at'),
            // Adicione outros campos que precisam ser atualizados
        ]);

        return redirect()->route('vendor.order.history')
            ->with('message', 'Ordem atualizada com sucesso!');
    }
}
