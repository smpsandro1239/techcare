<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $smartphone = Product::where('product_name', 'Smartphone XYZ')->first();
        ProductImage::create([
            'product_id' => $smartphone->id,
            'img_path' => 'products/smartphone_xyz_1.jpg',
            'is_primary' => true,
        ]);
        ProductImage::create([
            'product_id' => $smartphone->id,
            'img_path' => 'products/smartphone_xyz_2.jpg',
            'is_primary' => false,
        ]);

        $laptop = Product::where('product_name', 'Laptop ABC')->first();
        ProductImage::create([
            'product_id' => $laptop->id,
            'img_path' => 'products/laptop_abc_1.jpg',
            'is_primary' => true,
        ]);
    }
}
