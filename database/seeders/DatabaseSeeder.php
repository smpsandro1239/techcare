<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            AgendamentoSeeder::class,
            OrderSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
