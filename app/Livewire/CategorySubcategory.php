<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Collection;

class CategorySubcategory extends Component
{
    public $categories;
    public $selectedCategory;
    public Collection $subcategories;
    public $selectedSubcategory;
    public $categoryId;
    public $subcategoryId;

    public function mount($categoryId = null, $subcategoryId = null)
    {
        $this->categories = Category::all();
        $this->categoryId = $categoryId;
        $this->subcategoryId = $subcategoryId;

        // Inicializa como coleção vazia
        $this->subcategories = collect([]);

        // Define os valores iniciais
        $this->selectedCategory = old('category_id', $this->categoryId);
        $this->selectedSubcategory = old('subcategory_id', $this->subcategoryId) ?? null; // Preserva o valor inicial

        // Carrega subcategorias iniciais se houver categoria
        if ($this->selectedCategory) {
            $this->loadSubcategories();
        }
    }

    public function updatedSelectedCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadSubcategories();
    }

    protected function loadSubcategories()
    {
        if ($this->selectedCategory) {
            $this->subcategories = Subcategory::where('category_id', $this->selectedCategory)->get();
            // Só reseta $selectedSubcategory se o valor atual não for válido
            if ($this->selectedSubcategory && !$this->subcategories->contains('id', $this->selectedSubcategory)) {
                $this->selectedSubcategory = null;
            }
        } else {
            $this->subcategories = collect([]);
            $this->selectedSubcategory = null;
        }
    }

    public function render()
    {
        // Garante que $subcategories seja uma coleção
        if (!($this->subcategories instanceof Collection)) {
            $this->subcategories = collect($this->subcategories);
        }
        return view('livewire.category-subcategory');
    }
}
