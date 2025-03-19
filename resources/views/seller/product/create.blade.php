@extends('seller.layouts.layout')

@section('seller_page_title')
    Add Product
@endsection

@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Product</h5>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="product_name" class="fw-bold mb-2">Give Name of Your Product</label>
                    <input type="text" class="form-control mb-2" name="product_name" placeholder="">

                    <label for="description" class="fw-bold mb-2">Give a description of Your Product</label>
                    <textarea name="description" class="form-control mb-2" id="description" cols="30" rows="10"></textarea>

                    <label for="images" class="fw-bold mb-2">Upload Your Product Image</label>
                    <input type="file" class="form-control mb-2" name="images[]" multiple>

                    <livewire:category-subcategory/>

                    <label for="regular_price" class="fw-bold mb-2">Product Regular Price</label>
                    <input type="number" class="form-control mb-2" name="regular_price">

                    <button type="submit" class="btn btn-primary w-100 mt-2">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
