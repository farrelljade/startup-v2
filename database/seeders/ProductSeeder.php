<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'DERV'],
            ['name' => 'Kerosene'],
            ['name' => 'Gas Oil'],
            ['name' => 'IHO'],
            ['name' => 'AdBlue'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
