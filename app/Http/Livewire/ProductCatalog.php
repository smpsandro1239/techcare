<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductCatalog extends Component
{
    use WithPagination;

    // Definir o número de itens por página (1 neste caso)
    protected $paginationTheme = 'bootstrap'; // para usar a navegação do Bootstrap

    public function mount()
    {
        // Carregar os produtos com as imagens, categoria e subcategoria
        // A consulta já vai trazer 1 produto por página
    }

    public function render()
    {
        // Pagina os produtos, trazendo apenas 1 por página
        $products = Product::with(['images', 'category', 'subcategory'])
            ->paginate(4);  // Definido para trazer 1 produto por vez

        return view('livewire.product-catalog', [
            'products' => $products, // Passa os produtos paginados para a view
        ])->extends('layouts.app');
    }
}
