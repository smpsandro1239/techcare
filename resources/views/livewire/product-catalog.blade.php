<!-- resources/views/livewire/product-catalog.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-dark text-light border-0 shadow-lg product-card">
                    <!-- Imagem do Produto -->
                    @if($product->images->isNotEmpty())
                        @php
                            $primaryImage = $product->images->where('is_primary', true)->first();
                            $imagePath = $primaryImage ? $primaryImage->img_path : ($product->images->first()->img_path ?? 'default.jpg');
                        @endphp
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ asset('storage/' . $imagePath) }}"
                                 alt="{{ $product->product_name }}"
                                 class="card-img-top">
                        </a>
                    @else
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="https://via.placeholder.com/300x200"
                                 alt="Imagem indisponível"
                                 class="card-img-top">
                        </a>
                    @endif
                    <div class="card-body">
                        <!-- Nome do Produto -->
                        <h5 class="card-title text-success">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-success text-decoration-none">
                                {{ Str::limit($product->product_name, 50) }}
                            </a>
                        </h5>

                        <!-- Informações -->
                        <p class="card-text text-white">
                            <strong>Categoria:</strong> {{ optional($product->category)->name ?? 'Sem categoria' }}<br>
                            <strong>Subcategoria:</strong> {{ optional($product->subcategory)->name ?? 'Sem subcategoria' }}<br>
                            <strong>Vendedor:</strong> {{ optional($product->seller)->name ?? 'Sem vendedor' }}<br>
                        </p>

                        <!-- Preço -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->regular_price > 0)
                                    <span class="price">
                                        {{ number_format($product->regular_price, 2, ',', '.') }} €
                                    </span>
                                @else
                                    <span class="price">Preço não disponível</span>
                                @endif
                            </div>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-success btn-sm">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-white">
                <p>Nenhum produto encontrado.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
    <style>
        .product-card {
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3) !important;
        }

        .product-card .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 200px;
            object-fit: cover;
        }

        .product-card .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .product-card .card-text {
            font-size: 0.95rem;
            color: #bbb;
        }

        .product-card .price {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .product-card .btn-success {
            padding: 5px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .product-card .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .product-card .card-img-top {
                height: 150px;
            }

            .product-card .card-title {
                font-size: 1.1rem;
            }

            .product-card .card-text {
                font-size: 0.9rem;
            }

            .product-card .price {
                font-size: 1rem;
            }
        }
    </style>
@endpush
