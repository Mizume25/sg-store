<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{

    /** helper para obtener ids */



    /**
     * Metodos para poder obtener datos de las relaciones entre productos y categorias
     */
    public function run(): void
    {
        /** Leemos els products.json */
        $relations = json_decode(file_get_contents(database_path('data/relations.json')), true);

        /** Iteramos los datos */
        foreach ($relations as $relation) {
            //** Accedemos a los ids relacionados */
            $product = Product::where('name', $relation['product'])->first();
            $firstCategory = Category::where('name', $relation['categories'][0])->first();
            $secondCategory = Category::where('name', $relation['categories'][1])->first();

            //** Accedemos a la funcion del modelo */
            if ($product && $firstCategory && $secondCategory) {
                $product->categories()->attach([
                    $firstCategory->id,
                    $secondCategory->id
                ]);
            }
        }
    }
}
