@extends('seller.layouts.layout')

@section('seller_page_title')
    Editar Agendamento
@endsection

@section('seller_layout')
@include('layouts.partials.navbar')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm dashboard-card animate__animated animate__fadeIn" style="border: 1px solid rgba(255, 255, 255, 0.2) !important;">
                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="card-title mb-0" style="font-weight: 600;">Editar Agendamento</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('vendor.order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="scheduled_at" class="form-label text-white" style="font-weight: 500;">Data e Hora do Agendamento</label>
                            <input type="datetime-local" class="form-control custom-input" id="scheduled_at" name="scheduled_at"
                                   value="{{ old('scheduled_at', \Carbon\Carbon::parse($order->scheduled_at)->setTimezone(config('app.timezone'))->format('Y-m-d\TH:i')) }}" required>
                            @error('scheduled_at')
                                <div class="text-danger mt-1" style="font-size: 0.9rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary custom-btn">Salvar Alterações</button>
                            <a href="{{ route('admin.order.history') }}" class="btn btn-secondary custom-btn">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilização do formulário para harmonizar com o tema escuro */
    .custom-input {
        background-color: #1a1a1a !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .custom-input:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3) !important;
        outline: none;
    }

    .custom-btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.1s ease;
    }

    .custom-btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary.custom-btn {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }

    .btn-primary.custom-btn:hover {
        background-color: #0056b3 !important;
        border-color: #0056b3 !important;
    }

    .btn-secondary.custom-btn {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    .btn-secondary.custom-btn:hover {
        background-color: #5a6268 !important;
        border-color: #5a6268 !important;
    }
</style>
@endsection
