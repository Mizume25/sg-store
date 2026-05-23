<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Leemos els products.json */
        $products = json_decode(file_get_contents(database_path('data/products.json')), true);

        /** Iteramos datos json */
        foreach ($products as $product) {

            /** Obtenemos el modelo del producto realcionado  */
            $find = Product::where('name', $product['name'])->first();

            /** Iteramos las imagenes del json */
            foreach ($product['images'] as $image) {
               
                /** Creamos el modelo imagen */
                ProductsImage::create([
                    'path' => $image,
                    'product_id'=> $find->id
                ]);
            }
        }
    }
}
