<!-- resources/views/admin/order/history.blade.php -->
@extends('admin.layouts.layout')

@section('admin_page_title')
    Histórico de Agendamentos
@endsection

@section('admin_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Histórico de Agendamentos</h5>
            </div>

            @if (session('message'))
                <div class="alert alert-success my-3 mx-3">
                    <i class="fas fa-check-circle"></i> {{ session('message') }}
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
                                        <div class="btn-group" role="group">
                                            <!-- Botão Ver -->
                                            <a href="{{ route('admin.order.show', $order->id) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <!-- Botão Deletar -->
                                            <form action="{{ route('admin.order.destroy', $order->id) }}"
                                                  method="POST"
                                                  style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja deletar este agendamento?')">
                                                    <i class="fas fa-trash-alt"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Nenhum agendamento encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginação (se aplicável) -->
            @if ($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer bg-light">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
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
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
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
