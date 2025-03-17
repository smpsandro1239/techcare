@extends('layouts.app') {{-- Usa o layout principal --}}

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light border-0 shadow-lg" style="border-radius: 10px;">
                
                {{-- Imagem do Produto --}}
                @if($produto->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $produto->images->first()->img_path) }}" 
                         alt="{{ $produto->product_name }}" 
                         class="card-img-top" 
                         style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 350px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x200" 
                         alt="Imagem indisponível" 
                         class="card-img-top" 
                         style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 350px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h3 class="card-title text-success">{{ $produto->product_name }}</h3>

                    <p class="card-text text-white">
                        <strong>Categoria:</strong> {{ optional($produto->category)->category_name ?? 'Sem categoria' }}<br>
                        <strong>Subcategoria:</strong> {{ optional($produto->subcategory)->subcategory_name ?? 'Sem subcategoria' }}<br>
                        <strong>Loja:</strong> {{ optional($produto->store)->store_name ?? 'Sem loja' }}
                    </p>

                    <p class="text-white">{{ $produto->description }}</p> <!-- Alterado para text-white -->

                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-warning" style="font-size: 1.5rem; font-weight: bold;">
                            {{ $produto->regular_price }}€
                        </p>
                        <a href="#" class="btn btn-success">Comprar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection