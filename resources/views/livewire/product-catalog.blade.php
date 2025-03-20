<!-- resources/views/livewire/product-catalog.blade.php -->
<div class="container py-5">
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-dark text-light border-0 shadow-lg product-card">
                    <!-- Imagem do Produto -->
                    @if($product->images->isNotEmpty())
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->img_path ?? $product->images->first()->img_path) }}" 
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
                            {{-- Removido a parte que exibia a "Loja" --}}
                            <strong>Vendedor:</strong> {{ optional($product->seller)->name ?? 'Sem vendedor' }}<br>
                            <strong>Status do Estoque:</strong> 
                            <span class="stock-status {{ $product->stock_status }}">
                                {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                            </span>
                        </p>

                        <!-- Preço -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="price text-warning">
                                    R$ {{ number_format($product->discounted_price ?? $product->regular_price, 2, ',', '.') }}
                                </span>
                                @if($product->discounted_price && $product->discounted_price < $product->regular_price)
                                    <span class="discounted-price text-muted">
                                        R$ {{ number_format($product->regular_price, 2, ',', '.') }}
                                    </span>
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

    <!-- Paginação -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

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

        .product-card .discounted-price {
            font-size: 0.9rem;
            text-decoration: line-through;
            margin-left: 0.5rem;
        }

        .product-card .stock-status {
            font-size: 0.85rem;
            font-weight: bold;
            padding: 3px 8px;
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

            .product-card .discounted-price {
                font-size: 0.8rem;
            }
        }
    </style>
@endpush
    </div>
@endforeach
</div>
