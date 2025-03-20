@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Produto</h2>

    <form action="{{ route('vendor.product.update', $product->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome do Produto</label>
            <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Preço (€)</label>
            <input type="number" step="0.01" name="regular_price" value="{{ $product->regular_price }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
