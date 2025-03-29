@extends('customer.layouts.layout')

@section('customer_page_title')
    Editar Agendamento
@endsection

@section('customer_layout')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">Editar Agendamento</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('user.order.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="scheduled_at" class="form-label">Data de Agendamento</label>
                        <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" 
       value="{{ old('scheduled_at', \Carbon\Carbon::parse($order->scheduled_at)->setTimezone(config('app.timezone'))->format('Y-m-d\TH:i')) }}" required>

                    </div>

                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="{{ route('user.order.history') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
