<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $eletronicos = Category::where('category_name', 'Eletrônicos')->first();
        $perifericos = Category::where('category_name', 'Periféricos')->first();
        $acessorios = Category::where('category_name', 'Acessórios')->first();

        Subcategory::create(['subcategory_name' => 'Smartphones', 'category_id' => $eletronicos->id]);
        Subcategory::create(['subcategory_name' => 'Laptops', 'category_id' => $eletronicos->id]);
        Subcategory::create(['subcategory_name' => 'Teclados', 'category_id' => $perifericos->id]);
        Subcategory::create(['subcategory_name' => 'Mouses', 'category_id' => $perifericos->id]);
        Subcategory::create(['subcategory_name' => 'Capas', 'category_id' => $acessorios->id]);
    }
}
