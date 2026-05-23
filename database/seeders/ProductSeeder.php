<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Metodos para poder obtener productos
     */
    public function run(): void
    {
         /** Leemos els products.json */
        $products = json_decode(file_get_contents(database_path('data/products.json')), true);

        /** Iteramos los datos */
        foreach($products as $product)
        {
            Product::create([
                'name' => $product['name'],
                'code' => $product['code']. '-' . strtoupper(Str::random(4)),
                'description' => $product['description']
            ]);

        }
    }
}
