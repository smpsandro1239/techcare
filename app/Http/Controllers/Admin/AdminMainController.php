<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Report;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminMainController extends Controller
{
    /**
     * Exibe o dashboard do administrador.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Métricas
        $numAdmins = User::where('role', 1)->count();
        $numVendors = User::where('role', 2)->count();
        $numCustomers = User::where('role', 3)->count();
        $numProducts = Product::count();
        $totalProductValue = Product::sum('regular_price');
        $numAgendamentos = Agendamento::count();
        $numOrders = Order::count();

        // Dados para o gráfico de pizza (distribuição de utilizadores)
        $userDistribution = [
            'Administradores' => $numAdmins,
            'Vendedores' => $numVendors,
            'Clientes' => $numCustomers,
        ];

        // Dados para o gráfico de agendamentos por mês
        $agendamentosPorMes = Agendamento::select(
            DB::raw('MONTH(data) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // Preparar labels e dados para o gráfico de agendamentos
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $agendamentosData = [];
        for ($i = 1; $i <= 12; $i++) {
            $agendamentosData[] = $agendamentosPorMes[$i] ?? 0;
        }

        return view('admin.admin', compact(
            'numAdmins',
            'numVendors',
            'numCustomers',
            'numProducts',
            'totalProductValue',
            'numAgendamentos',
            'numOrders',
            'userDistribution',
            'meses',
            'agendamentosData'
        ));
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
     * Exibe a página de gerenciamento de utlizadores.
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
        // Carregar os vendedores
        $sellers = User::where('role', '2')->get(); // Aqui você ajusta conforme sua lógica de 'vendedores'

        $orders = Order::with(['user', 'agendamento', 'seller'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);
        return view('admin.order.history', compact('orders', 'sellers'));
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
        // Verifica se o pedido tem um agendamento associado e exclui
        if ($order->agendamento) {
            $order->agendamento->delete();
        }

        // Exclui o pedido
        $order->delete();

        return redirect()->route('admin.order.history')
            ->with('message', 'Ordem e agendamento cancelados com sucesso!');
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
        return view('admin.order.edit', compact('order'));
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

        return redirect()->route('admin.order.history')
            ->with('message', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Atribui um agendamento a um vendedor.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignAgendamento(Order $order, Request $request)
    {
        // Valida se o vendedor foi selecionado no formulário
        $request->validate([
            'seller_id' => 'required|exists:users,id',  // Valida que o seller_id é um ID de um usuário válido
        ]);

        // Atribui o agendamento ao vendedor selecionado
        $order->update([
            'seller_id' => $request->input('seller_id'),
        ]);

        return redirect()->route('admin.order.history')->with('message', 'Agendamento atribuído com sucesso!');
    }

    /**
     * Desatribui um agendamento de um vendedor.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unassignAgendamento(Order $order)
    {
        // Desatribui o vendedor do agendamento
        $order->update([
            'seller_id' => null,
        ]);

        return redirect()->route('admin.order.history')->with('message', 'Agendamento desatribuído com sucesso!');
    }

    /**
     * Método para atribuir o vendedor ao agendamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignSeller(Request $request, $orderId)
    {
        // Validar a entrada
        $request->validate([
            'seller_id' => 'required|exists:users,id', // O ID do vendedor deve ser válido
        ]);

        // Encontrar o agendamento
        $order = Order::findOrFail($orderId);

        // Atribuir o vendedor
        $order->seller_id = $request->input('seller_id');
        $order->save();

        // Redirecionar de volta com uma mensagem de sucesso
        return redirect()->route('admin.order.history')
            ->with('message', 'Vendedor atribuído com sucesso!');
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
        return redirect()->route('admin.order.history')->with('message', 'Relatório criado com sucesso!');
    }

    public function createReportForm(Order $order)
    {
        return view('admin.reports.create_report', compact('order'));
    }

    public function viewReports(Order $order)
    {
        // Buscar os relatórios associados a este pedido
        $reports = $order->reports;  // Supondo que você tem a relação definida corretamente

        return view('admin.reports.view_reports', compact('reports', 'order'));
    }

    public function destroyReport(Report $report)
    {
        // Deleta o relatório
        $report->delete();

        // Retorna para a lista de relatórios com uma mensagem de sucesso
        return redirect()->route('admin.order.view.reports', $report->order_id)
            ->with('message', 'Relatório excluído com sucesso!');
    }

    public function assignedAgendamentos()
    {
        // Busca todos os agendamentos atribuídos a vendedores
        $orders = Order::whereNotNull('seller_id') // Apenas pedidos atribuídos
            ->with(['user', 'agendamento', 'seller']) // Carrega relações
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.order.assigned-agendamentos', compact('orders'));
    }
}
