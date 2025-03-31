@extends('admin.layouts.layout')

@section('admin_page_title')
    Relatórios para o Agendamento #{{ $order->id }}
@endsection

@section('admin_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Relatórios para o Agendamento #{{ $order->id }}</h5>
            </div>

            <div class="card-body">
                @forelse($reports as $report)
                    <div class="report-item mb-3">
                        <h5>Relatório #{{ $report->id }}</h5>
                        <p><strong>Conteúdo:</strong> {{ $report->content }}</p>
                        <p><strong>Data de Criação:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>

                        <!-- Formulário para excluir relatório -->
                        <form action="{{ route('admin.report.delete', $report->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE') <!-- Essa diretiva permite o envio do método DELETE no formulário -->
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este relatório?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                @empty
                    <p>Nenhum relatório encontrado para este agendamento.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
