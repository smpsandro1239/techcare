@extends('layouts.app')

@section('title', 'Detalhes do Produto')

@section('styles')
    <style>
        .product-details {
            padding: 3rem 0;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
        }

        .product-card {
            background-color: #222;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .product-card .carousel-item img {
            height: 400px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .product-card .card-body {
            padding: 2rem;
        }

        .product-card .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .product-card .card-text {
            font-size: 1.1rem;
            color: #bbb;
            margin-bottom: 1rem;
        }

        .product-card .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }

        .product-card .discounted-price {
            font-size: 1.2rem;
            color: #dc3545;
            text-decoration: line-through;
            margin-left: 1rem;
        }

        .product-card .stock-status {
            font-size: 1rem;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .stock-status.in-stock {
            background-color: #28a745;
            color: white;
        }

        .stock-status.out-of-stock {
            background-color: #dc3545;
            color: white;
        }

        .stock-status.pre-order {
            background-color: #ffc107;
            color: black;
        }

        .product-card .btn-action {
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .product-card .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.5);
        }

        @media (max-width: 768px) {
            .product-card .carousel-item img {
                height: 250px;
            }

            .product-card .card-title {
                font-size: 1.5rem;
            }

            .product-card .card-text {
                font-size: 1rem;
            }

            .product-card .price {
                font-size: 1.2rem;
            }

            .product-card .discounted-price {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="product-details">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card product-card">
                        <!-- Carrossel de Imagens -->
                        @if($product->images->isNotEmpty())
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($product->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image->img_path) }}" 
                                                 alt="{{ $product->product_name }}" 
                                                 class="d-block w-100">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Anterior</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Próximo</span>
                                </button>
                            </div>
                        @else
                            <img src="https://via.placeholder.com/600x400" 
                                 alt="Imagem indisponível" 
                                 class="card-img-top">
                        @endif

                        <div class="card-body">
                            <h3 class="card-title">{{ $product->product_name }}</h3>

                            <p class="card-text">
                                <strong>Categoria:</strong> {{ optional($product->category)->name ?? 'Sem categoria' }}<br>
                                <strong>Subcategoria:</strong> {{ optional($product->subcategory)->name ?? 'Sem subcategoria' }}<br>
                                <strong>Preço Regular:</strong> {{ number_format($product->regular_price, 2, '.', ' ') }}<br> <!-- Corrigido formato -->
                                <strong>Descrição:</strong> {{ $product->description ?? 'Sem descrição disponível.' }}<br>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-action">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
