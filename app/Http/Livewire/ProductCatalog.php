<?php

// app/Http/Livewire/ProductCatalog.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCatalog extends Component
{
    public $products;

    public function mount()
    {
        // Verifique se os produtos estão sendo carregados corretamente
        $this->products = Product::with(['images', 'category', 'subcategory'])->get();
    }

    public function render()
    {
        return view('livewire.product-catalog')->layout('layouts.app'); 
    }
}

