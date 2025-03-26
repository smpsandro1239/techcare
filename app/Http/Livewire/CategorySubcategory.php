<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class CategorySubcategory extends Component
{
    public $categories; // Todas as categorias
    public $selectedCategory; // Categoria selecionada
    public $subcategories; // Subcategorias filtradas

    public function mount()
    {
        $this->categories = Category::all();
        $this->selectedCategory = old('category_id'); // Carrega valor antigo, se existir
        $this->updatedSelectedCategory($this->selectedCategory); // Inicializa subcategorias
    }

    public function updatedSelectedCategory($categoryId)
    {
        if ($categoryId) {
            $this->subcategories = Subcategory::where('category_id', $categoryId)->get();
        } else {
            $this->subcategories = []; // Limpa subcategorias se nenhuma categoria for selecionada
        }
    }

    public function render()
    {
        return view('livewire.category-subcategory');
    }
}
