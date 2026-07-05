<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   
    /***
     * Incia el Dashboard
     */
     public function __invoke()
    {
        $products = Product::with('rates', 'categories', 'images')->get();

        return view('dashboard', compact('products'));
    }
}
