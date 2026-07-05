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
        $amount = $this->amount($request->product_id, $request->units , $request->order_date);

        if($amount == 0) return back()->with('error', 'No existe tarifa para la fecha indicada');


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
     * @param string $date
     * @param int $units
     */
    private function amount(int $productID, int $units , $date)
    {
        /** Tarifa vigente para la fecha del pedido */
        $rate = Rate::where('product_id', $productID)
        ->where('start_date', '<=' , $date)
        ->where('end_date', '>=', $date)
        ->orderBy('start_date', 'desc')
        ->first();

        if(!$rate) return 0;

        return $rate->price * $units;
    }

    /**
     * Editar order
     * @param $request
     * @param $id 
     */
    public function update (Request $request , string $id) 
    {   
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_date'    => 'required|date',
            'units'         => 'required|integer|min:1',
        ]);

       


         $order = Order::findOrFail($id);

         $amount = $this->amount($request->product_id, $request->units , $request->order_date);
         if($amount == 0) return back()->with('error', 'No existe tarifa para la fecha indicada');

          
          $order->update([
            'order_date' => $request->order_date,
            'units' => $request->units,
            'amount' => $amount,
            'product_id' => $request->product_id,
          ]);

           return back()->with('success', 'Orden Actualizada correctamente');

    }

    /**
     * Eliminar orden
     * @param $id
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return back()->with('succes', 'Order Eliminado correctamente');

    }

    /** Pedido en formato json */
    public function apiOrders()
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
