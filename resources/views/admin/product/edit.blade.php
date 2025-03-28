@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Produto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nome do Produto</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" required>
            @error('product_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria/Subcategoria</label>
            <livewire:category-subcategory :categoryId="$product->category_id" :subcategoryId="$product->subcategory_id" />
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @error('subcategory_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Preço (€)</label>
            <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" class="form-control" required>
            @error('regular_price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

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

        <div class="mb-3">
            <label class="form-label">Adicionar Novas Imagens</label>
            <input type="file" name="images[]" class="form-control" multiple>
            @error('images.*')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection