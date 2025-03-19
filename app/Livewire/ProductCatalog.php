<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCatalog extends Component
{
    public $products;

    public function mount()
    {
        // Carregar os produtos com as imagens e as relações associadas
        $this->products = Product::with(['images', 'category', 'subcategory'])->get();
    }

    public function render()
    {
        return view('livewire.product-catalog', [
            'products' => $this->products, // Passa os produtos para a view
        ])->extends('layouts.app');
    }
}
