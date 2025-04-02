<!-- resources/views/livewire/product-catalog.blade.php -->
<div> <!-- Tag raiz única para o componente -->
    <div class="container py-5">
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card bg-dark text-light border-0 shadow-lg product-card">
                        @php
                            $primaryImage = $product->images->where('is_primary', true)->first();
                            $imagePath = $primaryImage ? $primaryImage->img_path : ($product->images->first()->img_path ?? 'default.jpg');
                        @endphp
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->product_name }}" class="card-img-top">
                        </a>

                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <a href="{{ route('product.show', $product->slug) }}" class="text-success text-decoration-none">
                                    {{ Str::limit($product->product_name, 50) }}
                                </a>
                            </h5>

                            <p class="card-text text-white">
                                <strong>Categoria:</strong> {{ optional($product->category)->category_name ?? 'Sem categoria' }}<br>
                                <strong>Subcategoria:</strong> {{ optional($product->subcategory)->subcategory_name ?? 'Sem subcategoria' }}<br>
                            </p>

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
</div> <!-- Fim da tag raiz -->
