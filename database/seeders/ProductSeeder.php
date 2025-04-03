<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendor = User::where('email', 'vendor@example.com')->first();
        $eletronicos = Category::where('category_name', 'Eletrônicos')->first();
        $smartphones = Subcategory::where('subcategory_name', 'Smartphones')->first();

        Product::create([
            'product_name' => 'Smartphone XYZ',
            'description' => 'Um smartphone de última geração.',
            'seller_id' => $vendor->id,
            'category_id' => $eletronicos->id,
            'subcategory_id' => $smartphones->id,
            'regular_price' => 999.99,
            'slug' => Str::slug('Smartphone XYZ'),
        ]);

        $laptops = Subcategory::where('subcategory_name', 'Laptops')->first();
        Product::create([
            'product_name' => 'Laptop ABC',
            'description' => 'Um laptop poderoso para trabalho e jogos.',
            'seller_id' => $vendor->id,
            'category_id' => $eletronicos->id,
            'subcategory_id' => $laptops->id,
            'regular_price' => 1499.99,
            'slug' => Str::slug('Laptop ABC'),
        ]);
    }
}
