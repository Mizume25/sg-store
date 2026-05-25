<?php

namespace App\Http\Controllers;

use App\Models\Product;

use function PHPSTORM_META\map;

/**
 * Controlador Principal
 */
class CatalogController extends Controller
{   
    /** Funcion que retorna la vista home */
    public function home() 
    {   

        /*Maquetar Productos */
        $products = Product::with('rates', 'categories', 'images')->get(); 

        /** Pasamos producto */
        return view('dashboard', compact('products'));
    }
}
