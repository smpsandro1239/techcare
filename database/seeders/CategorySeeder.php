<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['category_name' => 'Eletrônicos']);
        Category::create(['category_name' => 'Periféricos']);
        Category::create(['category_name' => 'Acessórios']);
    }
}
