<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class CategorySubcategory extends Component
{
    public $categories=[];
    public $selectedCategory;
    public $subcategories=[];
    public function mount (){
        $this->categories=Category::all();
    }

    public function updatedSelectedCategory($categoryId){
    $this->subcategories = Subcategory::where('category_id',$categoryId)->get();

    }
    public function render()
    {
        return view('livewire.category-subcategory');
    }
}
