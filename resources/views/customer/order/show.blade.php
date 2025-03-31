<!-- resources/views/admin/order/show.blade.php -->

@extends('customer.layouts.layout')

@section('customer_layout')
    <div class="container">
        <h1>Detalhes do Pedido</h1>

        <table class="table">
            <tr>
                <th>Nome do Cliente</th>
                <td>{{ $order->agendamento->nome_cliente }}</td>
            </tr>
            <tr>
                <th>Data Agendada</th>
                <!-- Usando Carbon::parse() para formatar a data -->
                <td>{{ \Carbon\Carbon::parse($order->scheduled_at)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Serviço</th>
                <td>{{ $order->agendamento->servico }}</td>
            </tr>
            <tr>
                <th>Duração</th>
                <td>{{ $order->agendamento->duracao }}</td>
            </tr>
            <tr>
                <th>Usuário</th>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <th>Email do Usuário</th>
                <td>{{ $order->user->email }}</td>
            </tr>
            <tr>
                <th>Data de Criação</th>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Data de Atualização</th>
                <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
@endsection
