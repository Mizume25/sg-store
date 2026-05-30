<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('orders.calendar', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_date' => 'required|date|after_or_equal:today',
            'units'      => 'required|integer|min:1',
        ]);

        /** Llamamos a la funcion del calculo amount */
        $amount = $this->amount($request->product_id, $request->units);

        /** Creamos registro a la base de datos */
        Order::create([
            'order_date' => $request->order_date,
            'units' => $request->units,
            'amount' => $amount,
            'product_id' => $request->product_id
        ]);

        return back()->with('success', 'Orden Registrada correctamente');
    }

    /** Calculo de precio final 
     * @param int $productID
     */
    private function amount(int $productID, int $units)
    {
        /** Obtenemos la fecha mas "actual"  */
        $rate = Rate::where('product_id', $productID)
            ->orderBy('end_date', 'desc')
            ->first();

        if (!$rate) return 0;

        return $rate->price * $units;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function apiOrders()
    {
        $orders = Order::with('product')->get()->map(fn($o) => [
            'title' => $o->product->name . ' x' . $o->units . ' (' . $o->amount . '€)',
            'start' => $o->order_date,
        ]);

        return response()->json($orders);
    }
}
