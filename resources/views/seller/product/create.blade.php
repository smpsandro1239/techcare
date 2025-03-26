<!-- resources/views/admin/product/create.blade.php -->
@extends('layouts.app')

@section('title', 'Adicionar Produto')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-light border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Adicionar Produto</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nome do Produto -->
                            <div class="mb-3">
                                <label for="product_name" class="form-label fw-bold text-white">Nome do Produto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-secondary text-white border-0" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="Insira o nome do produto" required>
                                @error('product_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold text-white">Descrição</label>
                                <textarea class="form-control bg-secondary text-white border-0" id="description" name="description" rows="4" placeholder="Insira a descrição do produto">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Linha 1: Vendedor e Categoria/Subcategoria -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="seller_id" class="form-label fw-bold text-white">Vendedor <span class="text-danger">*</span></label>
                                    <select class="form-control bg-secondary text-white border-0" id="seller_id" name="seller_id" required>
                                        @foreach (\App\Models\User::where('role', 'vendor')->get() as $seller)
                                            <option value="{{ $seller->id }}" {{ old('seller_id') == $seller->id ? 'selected' : '' }}>{{ $seller->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('seller_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-white">Categoria e Subcategoria <span class="text-danger">*</span></label>
                                    <livewire:category-subcategory />
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('subcategory_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Linha 2: Preços -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="regular_price" class="form-label fw-bold text-white">Preço Normal (€) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control bg-secondary text-white border-0" id="regular_price" name="regular_price" value="{{ old('regular_price') }}" placeholder="Insira o preço normal" required>
                                    @error('regular_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="discounted_price" class="form-label fw-bold text-white">Preço com Desconto (€)</label>
                                    <input type="number" step="0.01" class="form-control bg-secondary text-white border-0" id="discounted_price" name="discounted_price" value="{{ old('discounted_price') }}" placeholder="Insira o preço com desconto">
                                    @error('discounted_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Linha 3: Taxa de Imposto e Quantidade em Stock -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tax_rate" class="form-label fw-bold text-white">Taxa de IVA (%)</label>
                                    <input type="number" step="0.01" class="form-control bg-secondary text-white border-0" id="tax_rate" name="tax_rate" value="{{ old('tax_rate') }}" placeholder="Insira a taxa de IVA">
                                    @error('tax_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="stock_quantity" class="form-label fw-bold text-white">Quantidade em Stock <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control bg-secondary text-white border-0" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" placeholder="Insira a quantidade" required>
                                    @error('stock_quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Linha 4: Estado do Stock, Visibilidade e Estado -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="stock_status" class="form-label fw-bold text-white">Estado do Stock <span class="text-danger">*</span></label>
                                    <select class="form-control bg-secondary text-white border-0" id="stock_status" name="stock_status" required>
                                        <option value="in_stock" {{ old('stock_status') == 'in_stock' ? 'selected' : '' }}>Em Stock</option>
                                        <option value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Esgotado</option>
                                        <option value="pre_order" {{ old('stock_status') == 'pre_order' ? 'selected' : '' }}>Pré-encomenda</option>
                                    </select>
                                    @error('stock_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="visibility" class="form-label fw-bold text-white">Visibilidade <span class="text-danger">*</span></label>
                                    <select class="form-control bg-secondary text-white border-0" id="visibility" name="visibility" required>
                                        <option value="1" {{ old('visibility', 1) == 1 ? 'selected' : '' }}>Visível</option>
                                        <option value="0" {{ old('visibility') == 0 ? 'selected' : '' }}>Oculto</option>
                                    </select>
                                    @error('visibility')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-bold text-white">Estado <span class="text-danger">*</span></label>
                                    <select class="form-control bg-secondary text-white border-0" id="status" name="status" required>
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Ativo</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- SEO: Título e Descrição -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="meta_title" class="form-label fw-bold text-white">Título Meta (SEO)</label>
                                    <input type="text" class="form-control bg-secondary text-white border-0" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="Insira o título meta">
                                    @error('meta_title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_description" class="form-label fw-bold text-white">Descrição Meta (SEO)</label>
                                    <textarea class="form-control bg-secondary text-white border-0" id="meta_description" name="meta_description" rows="2" placeholder="Insira a descrição meta">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Imagens -->
                            <div class="mb-3">
                                <label for="images" class="form-label fw-bold text-white">Imagens do Produto</label>
                                <input type="file" class="form-control bg-secondary text-white border-0" id="images" name="images[]" multiple>
                                @error('images.*')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-3">Adicionar Produto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card {
                background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
            }

            .form-control, .form-select {
                background-color: #333 !important;
                border: 1px solid #444 !important;
                color: #fff !important;
            }

            .form-control:focus, .form-select:focus {
                background-color: #444 !important;
                border-color: #28a745 !important;
                box-shadow: 0 0 5px rgba(40, 167, 69, 0.5) !important;
            }

            .btn-success {
                background-color: #28a745;
                border: none;
                transition: all 0.3s ease;
            }

            .btn-success:hover {
                background-color: #218838;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(40, 167, 69, 0.5);
            }

            .alert-dismissible .btn-close {
                filter: invert(1);
            }
        </style>
    @endpush
@endsection
