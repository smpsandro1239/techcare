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

        $this->subcategories = collect([]);

        $this->selectedCategory = old('category_id', $this->categoryId);
        $this->selectedSubcategory = old('subcategory_id', $this->subcategoryId) ?? null;

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
        if (!($this->subcategories instanceof Collection)) {
            $this->subcategories = collect($this->subcategories);
        }
        return view('livewire.category-subcategory');
    }
}
