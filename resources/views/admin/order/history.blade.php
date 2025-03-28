<!-- resources/views/admin/order/history.blade.php -->

@extends('admin.layouts.layout')

@section('admin_layout')
    <div class="container">
        <h1>Histórico de Agendamentos</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Agendamento ID</th>
                    <th>Usuário</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->agendamento->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
