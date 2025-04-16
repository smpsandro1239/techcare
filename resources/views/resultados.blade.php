@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 50px;">
    <h2 class="text-light">Resultados da Pesquisa</h2>
    <br>
    @if ($products->isEmpty())
        <p class="text-warning">Nenhum produto encontrado.</p>
    @else
        <div class="row">
            @foreach ($products as $produto)
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-light border-0 shadow-lg" style="border-radius: 10px;">
                        <!-- Imagem do Produto -->
                        @if($produto->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $produto->images->first()->img_path) }}" 
                                 alt="{{ $produto->product_name }}" 
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        @else
                            <img src="https://via.placeholder.com/300x200" 
                                 alt="Imagem indisponível" 
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        @endif

                        <div class="card-body">
                            <!-- Nome do Produto -->
                            <h5 class="card-title" style="color: #0dcaf0; font-size: 1.2rem; height: 50px; overflow: hidden;">
                                <a href="{{ route('product.show', $produto->id) }}" class="text-decoration-none" style="color: #0dcaf0;">
                                    {{ $produto->product_name }}
                                </a>
                            </h5>

                            <!-- Preço do Produto -->
                            <p class="card-text text-warning" style="font-size: 1rem;">
                                {{ $produto->regular_price }}€
                            </p>

                            <!-- Descrição do Produto (opcional) -->
                            <p class="card-text text-white" style="font-size: 0.9rem; height: 50px; overflow: hidden;">
                                {{ Str::limit($produto->description, 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('product.show', $produto->slug) }}" class="btn btn-sm" style="background-color: #0dcaf0; color: #000;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('catalogo') }}" class="btn mt-3" style="border: 1px solid #0dcaf0; color: #0dcaf0;">
        Voltar ao Catálogo
    </a>
</div>
@endsection
