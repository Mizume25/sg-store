<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Metodos para obtener 2 tarifas por producto
     */
    public function run(): void
    {
        Product::all()->each(function ($product) {
            
            Rate::factory(2)->create([
                'product_id' => $product->id
            ]);
        });
    }
}
