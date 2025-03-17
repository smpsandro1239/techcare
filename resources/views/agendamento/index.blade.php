@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agendamentos</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nome do Cliente</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Serviço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendamentos as $agendamento)
                <tr>
                    <td>{{ $agendamento->nome_cliente }}</td>
                    <td>{{ $agendamento->data }}</td>
                    <td>{{ $agendamento->hora }}</td>
                    <td>{{ $agendamento->servico }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection