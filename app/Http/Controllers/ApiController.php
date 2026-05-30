<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products()
    {
        return response()->json(
            Product::with(['categories', 'rates', 'images'])->get()
        );
    }

    public function product(int $id)
    {
        return response()->json(
            Product::with(['categories', 'rates', 'images'])->findOrFail($id)
        );
    }

    public function categories()
    {
        return response()->json(Category::with('childrens')->get());
    }

    public function orders()
    {
        return response()->json(Order::with('product')->get());
    }
}
