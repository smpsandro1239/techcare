<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCatalog extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::with(['images', 'category', 'subcategory'])->get();
    }

    public function render()
    {
        return view('livewire.product-catalog');
    }
}
