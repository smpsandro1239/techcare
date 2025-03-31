@extends('seller.layouts.layout')

@section('seller_page_title')
    Criar Relatório
@endsection

@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Criar Relatório para Agendamento #{{ $order->id }}</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('vendor.order.generate.report', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="content">Conteúdo do Relatório:</label>
                        <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> Criar Relatório
                        </button>
                        <a href="{{ route('vendor.order.history') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
