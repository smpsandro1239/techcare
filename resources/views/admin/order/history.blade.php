@extends('admin.layouts.layout')

@section('admin_page_title')
    Histórico de Agendamentos
@endsection

@section('admin_layout')
@include('layouts.partials.navbar')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Histórico de Agendamentos</h5>
                <a href="{{ route('admin.assigned.agendamentos') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-check-circle"></i> Agendamentos Atribuídos
                </a>
            </div>

            @if (session('message'))
                <div class="alert alert-success my-3 mx-3">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger my-3 mx-3">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Agendamento ID</th>
                                <th scope="col">Usuário</th>
                                <th scope="col">Data de Criação</th>
                                <th scope="col">Vendedor Atribuído</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->agendamento->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($order->seller)
                                            {{ $order->seller->name }}
                                        @else
                                            Nenhum vendedor atribuído
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Atribuir Agendamento -->
                                            @if (!$order->seller_id)
                                                <form action="{{ route('admin.agendamento.assign', $order->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <select name="seller_id" class="form-control form-control-sm mr-2" required>
                                                        <option value="">Escolha um vendedor</option>
                                                        @foreach($sellers as $seller)
                                                            <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-user-check"></i> Atribuir
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Desatribuir Agendamento -->
                                                <form action="{{ route('admin.agendamento.unassign', $order->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-user-times"></i> Desatribuir
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Botão Ver -->
                                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>

                                            <!-- Botão Editar -->
                                            <a href="{{ route('admin.order.edit', $order->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>

                                            <!-- Botão Deletar -->
                                            <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este agendamento?')">
                                                    <i class="fas fa-trash-alt"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Nenhum agendamento encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .table th, .table td {
        vertical-align: middle;
        background: transparent !important;
    }

    .table tbody tr {
        background: transparent !important;
    }

    .table tbody tr:hover {
        background-color: #333 !important;
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 20px; /* Bordas arredondadas */
        padding: 6px 12px; /* Tamanho consistente */
        font-size: 14px; /* Tamanho da fonte consistente */
        transition: all 0.3s ease; /* Efeito de transição suave */
    }

    .btn-group .btn i {
        margin-right: 5px; /* Alinhamento do ícone */
    }

    .btn-group .btn:hover {
        transform: translateY(-2px); /* Efeito de elevação */
    }

    .alert {
        border-radius: 8px;
    }

    .table-dark th {
        background-color: #343a40 !important;
        color: #fff !important;
    }

    .text-muted {
        color: #bbb !important;
    }
</style>
@endsection
