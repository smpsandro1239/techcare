<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCatalog extends Component
{
    public $products;

    public function mount()
    {
        // Carregar produtos com as relações (categoria, subcategoria, vendedor e imagens)
        $this->products = Product::with(['category', 'subcategory', 'seller', 'images'])->get();
    }

    public function render()
{
    // Usando o caminho correto para o layout
    return view('livewire.product-catalog')->layout('layouts.app');
}

}
