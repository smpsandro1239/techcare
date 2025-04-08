<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Report;
use Carbon\Carbon;

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
    // Verifica se o pedido tem um agendamento associado e exclui
    if ($order->agendamento) {
        $order->agendamento->delete();
    }

    // Exclui o pedido
    $order->delete();

    return redirect()->route('vendor.order.history')
        ->with('message', 'Ordem e agendamento cancelados com sucesso!');
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
    $request->validate([
        'scheduled_at' => 'required|date',
    ]);

    // Converte o horário recebido para o formato correto com o fuso horário
    $scheduledAt = Carbon::parse($request->input('scheduled_at'))->setTimezone(config('app.timezone'));

    // Atualiza o campo scheduled_at da tabela orders
    $order->update([
        'scheduled_at' => $scheduledAt,
    ]);

    // Se o pedido tiver um agendamento relacionado, atualiza os campos 'data' e 'hora'
    if ($order->agendamento) {
        $order->agendamento->update([
            'data' => $scheduledAt->format('Y-m-d'), // Atualiza o campo 'data' com a data (sem hora)
            'hora' => $scheduledAt->format('H:i'),   // Atualiza o campo 'hora' com a hora formatada
        ]);
    }

    return redirect()->route('vendor.order.history')
        ->with('message', 'Agendamento atualizado com sucesso!');
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
    // Nova função para gerar o relatório de um agendamento
    public function generateReport(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        // Criação do relatório
        $report = new Report();
        $report->order_id = $order->id;
        $report->user_id = auth()->id();
        $report->content = $request->input('content');
        $report->save();
    
        // Redirecionar com sucesso
        return redirect()->route('vendor.order.history')->with('message', 'Relatório criado com sucesso!');
    }    

    public function createReportForm(Order $order)
{
    return view('seller.reports.create_report', compact('order'));
}

public function viewReports(Order $order)
{
    // Buscar os relatórios associados a este pedido
    $reports = $order->reports;  // Supondo que você tem a relação definida corretamente

    return view('seller.reports.view_reports', compact('reports', 'order'));
}

public function destroyReport(Report $report)
{
    
    // Deleta o relatório
    $report->delete();

    // Retorna para a lista de relatórios com uma mensagem de sucesso
    return redirect()->route('vendor.order.view.reports', $report->order_id)
                     ->with('message', 'Relatório excluído com sucesso!');
}


}
