@extends('customer.layouts.layout')

@section('customer_page_title')
    Relatórios do Agendamento #{{ $order->id }}
@endsection

@section('customer_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Relatórios do Agendamento #{{ $order->id }}</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Conteúdo</th>
                                <th scope="col">Data de Criação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ $report->content }}</td>
                                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Nenhum relatório encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginação (se aplicável) -->
            @if ($reports instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer bg-light">
                    {{ $reports->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
