@extends('seller.layouts.layout')

@section('seller_page_title')
    Manage Product
@endsection

@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Products Added by You</h5> 
            </div>

            @if (session('message'))
                <div class="alert alert-success my-2">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ number_format($product->regular_price, 2, ',', '.') }}€</td>
                                <td>
                                    <!-- Link to Edit Product - You can modify the route as needed -->
                                    <a href="{{ route('vendor.product.edit', $product->id) }}" class="btn btn-info">Edit</a>
                                    
                                    <!-- Delete Product Form -->
                                    <form action="{{ route('vendor.product.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este produto?')">
                                      Deletar
                                    </button>
                                 </form>

                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
