<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{

    /**
     * Retorna la descripción de una categoría
     * @param string $category
     * @return string
     */
    private function descriptions(string $category): string
    {
        $descriptions = [
            'manzanas' => 'Manzanas frescas de temporada, cultivadas en huertos seleccionados.',
            'peras' => 'Peras jugosas y dulces, perfectas para consumo directo o postres.',
            'zanahorias' => 'Zanahorias cultivadas de forma natural, ricas en vitamina A.',
            'lechugas' => 'Lechugas frescas de hoja crujiente, ideales para ensaladas.',
            'pollo' => 'Pollo de granja criado en libertad, sin antibióticos.',
            'ternera' => 'Ternera de primera calidad, tierna y con sabor intenso.',
            'leche' => 'Leche fresca de vaca, procesada con los más altos estándares de calidad.',
            'quesos' => 'Quesos artesanales elaborados con leche de origen controlado.',
            'frutas' => 'Selección de las mejores frutas de temporada.',
            'verduras' => 'Verduras frescas cultivadas localmente.',
            'carnes' => 'Carnes de primera calidad seleccionadas por nuestros expertos.',
            'lacteos' => 'Productos lácteos frescos de origen certificado.',
        ];

        return $descriptions[$category] ?? "productos";
    }

    /**
     * Metodos para poder obtener los datos categoricos
     */
    public function run(): void
    {
        /** Leemos el catalog.json */
        $catalog = json_decode(file_get_contents(database_path('data/catalog.json')), true);

        /** Iteraremos los datos */
        foreach ($catalog as $category) 
        {

            /** Creamos etiquetas padre  */
            $parent = Category::create([
                'name' => $category['name'],
                'code' => strtoupper(substr($category['name'], 0, 3)). '-' . strtoupper(Str::random(4)),
                'description' => $this->descriptions($category['name'])
            ]);

                /** Creamos subcategorías hijas */
                foreach ($category['children'] as $child) 
                {
                    Category::create([
                        'name' => $child['name'],
                        'code' => strtoupper(substr($child['name'], 0,4)). '-' . strtoupper(Str::random(4)),
                        'description' => $this->descriptions($child['name']),
                        'parent_id' => $parent->id
                    ]);
                }
        }
    }
}
