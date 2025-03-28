@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Produto</h2>

    <form action="{{ route('vendor.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Adicionando o método PUT -->

        <div class="mb-3">
            <label class="form-label">Nome do Produto</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Preço (€)</label>
            <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" class="form-control" required>
        </div>

        {{-- Exibir imagens atuais se existirem --}}
        @if ($product->images->count() > 0)
            <div class="mb-3">
                <label class="form-label">Imagens Atuais</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($product->images as $image)
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image->img_path) }}" alt="Imagem do Produto" class="img-thumbnail" width="150">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                                <label class="form-check-label">Remover</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Upload de novas imagens --}}
        <div class="mb-3">
            <label class="form-label">Adicionar Novas Imagens</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
