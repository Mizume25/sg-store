<?php

namespace App\Http\Controllers;

/**
 * Controlador Principal
 */
class CatalogController extends Controller
{   
    /** Funcion que retorna la vista home */
    public function home() 
    {
        return view('dashboard');
    }
}
