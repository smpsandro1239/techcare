<div>
@foreach($products as $product)
    <div class="col-md-4 mb-4"> 
        <div class="card bg-dark text-light border-0 shadow-lg" style="border-radius: 10px;">
            <!-- Imagem do produto -->
            @if($product->images->isNotEmpty())
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->img_path) }}" 
                        alt="{{ $product->product_name }}" 
                        class="card-img-top" 
                        style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 200px; object-fit: cover;">
                @endforeach
            @else
                <img src="https://via.placeholder.com/300x200" 
                     alt="Imagem indisponível" 
                     class="card-img-top" 
                     style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 200px; object-fit: cover;">
            @endif

            <div class="card-body">
                <!-- Nome do produto -->
                <h5 class="card-title text-success">{{ $product->product_name }}</h5>
                
                <!-- Informações -->
                <p class="card-text text-white"> <!-- Alterado para text-white -->
                    <strong>Categoria:</strong> {{ optional($product->category)->category_name ?? 'Sem categoria' }}<br>
                    <strong>Subcategoria:</strong> {{ optional($product->subcategory)->subcategory_name ?? 'Sem subcategoria' }}
                </p>

                <!-- Preço e botão -->
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-warning" style="font-size: 1.2rem; font-weight: bold;">
                        {{ $product->regular_price }}€
                    </p>
                    <a href="#" class="btn btn-success">Comprar</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
