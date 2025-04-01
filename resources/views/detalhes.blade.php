@extends('layouts.app') {{-- Usa o layout principal --}}

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light border-0 shadow-lg" style="border-radius: 10px;">
                
                {{-- Imagem do Produto --}}
                @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->img_path) }}" 
                         alt="{{ $product->product_name }}" 
                         class="card-img-top" 
                         style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 350px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x200" 
                         alt="Imagem indisponível" 
                         class="card-img-top" 
                         style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 350px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h3 class="card-title text-success">{{ $product->product_name }}</h3>

                    <p class="card-text text-white">
                        <strong>Categoria:</strong> {{ optional($product->category)->category_name ?? 'Sem categoria' }}<br>
                        <strong>Subcategoria:</strong> {{ optional($product->subcategory)->subcategory_name ?? 'Sem subcategoria' }}<br>
                        {{-- Removido o trecho de exibição de loja --}}
                    </p>

                    <p class="text-white">{{ $product->description }}</p> <!-- Alterado para text-white -->

                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-warning" style="font-size: 1.5rem; font-weight: bold;">
                            {{ $product->regular_price }}€
                        </p>
                        <a href="{{ route('home') }}"  class="btn btn-success">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
