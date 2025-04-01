<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCatalog extends Component
{
    public $products;

    public function mount()
    {
        // Carregar os produtos com as imagens, categoria e subcategoria
        // Remover a relação com 'store', pois a tabela foi removida
        $this->products = Product::with(['images', 'category', 'subcategory','seller', 'images'])->get();
    }

    public function render()
    {
        return view('livewire.product-catalog', [
            'products' => $this->products, // Passa os produtos para a view
        ])->extends('layouts.app');
    }
}
