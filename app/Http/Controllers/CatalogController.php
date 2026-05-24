<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador Principal
 */
class CatalogController extends Controller
{   
    /** Funcion que retorna la vista home */
    public function home() 
    {
        return view('home');
    }
}
