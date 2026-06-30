<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{   
    /**
     * Funcion que retorna productos en json
     */
    public function products()
    {
        return response()->json(
            Product::with(['categories', 'rates', 'images'])->get()
        );
    }

    /**
     * Funcion que retorna producto espcifico en formato json
     * @param $id product
     */
    public function product(int $id)
    {
        return response()->json(
            Product::with(['categories', 'rates', 'images'])->findOrFail($id)
        );
    }

    /**
     * Funcion que retrona categorias en formato json
     */
    public function categories()
    {
        return response()->json(Category::all());
    }

    /**
     * Listado de ordenes
     */
    public function orders()
    {
        $orders = Order::with('product')->get()->map(fn($o) => [
            'id'      => $o->id,
            'title'   => $o->product->name . ' x' . $o->units . ' (' . $o->amount . '€)',
            'start'   => $o->order_date,
            'product' => $o->product->id,
            'units'   => $o->units,
            'total'   => $o->amount,
        ]);

        return response()->json($orders);
    }
}
