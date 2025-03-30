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

        $order->delete();
        return redirect()->route('vendor.order.history')
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
    
     /**
     * Atribui um vendedor autenticado a um agendamento.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign(Order $order)
    {
        // Verifica se já tem um vendedor atribuído
        if ($order->seller_id) {
            return redirect()->back()->with('error', 'Este agendamento já foi atribuído a um vendedor.');
        }

        // Atribuir o agendamento ao vendedor autenticado
        $order->update([
            'seller_id' => auth()->id(),
        ]);

        return redirect()->back()->with('message', 'Você foi atribuído a este agendamento com sucesso!');
    }
    /**
     * Desatribui o vendedor de um agendamento.
     *
     * @param  int  $agendamentoId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unassign($agendamentoId)
    {
        $order = Order::where('id', $agendamentoId)->where('seller_id', auth()->id())->firstOrFail();

        $order->update([
            'seller_id' => null,
        ]);

        return redirect()->route('vendor.order.history')->with('message', 'Você foi removido deste agendamento com sucesso!');
    }
    /**
     * Exibe os agendamentos atribuídos ao vendedor.
     *
     * @return \Illuminate\View\View
     */
    public function assignedAgendamentos()
    {
        // Busca os agendamentos atribuídos ao vendedor autenticado
        $orders = Order::where('seller_id', auth()->id())  // Filtra os agendamentos atribuídos ao vendedor
            ->with(['user', 'agendamento'])  // Carrega as relações necessárias
            ->orderBy('created_at', 'desc')  // Ordena pela data de criação
            ->paginate(10);  // Pagina os resultados

        return view('seller.order.assigned-agendamentos', compact('orders'));
    }
}
