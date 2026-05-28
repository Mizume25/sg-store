<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use App\Models\Rate;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class ProductsController extends Controller
{

    public function __construct(private ImageService $imageService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validamos datos del request */
        $request->validate([
            'name' => 'required|max:255|min:4|unique:products,name',
            'description' => 'required|max:500',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:categories,id',
            'rates' => 'required|array|min:1',
            'rates.*.price' => 'required|numeric|min:0',
            'rates.*.start_date' => 'required|date',
            'rates.*.end_date' => 'required|date|after:rates.*.start_date',
            'image1' => 'required|image|mimes:jpg,png,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);



        /** Creamos el codigo */
        $code = strtoupper(substr($request->name, 0, 3)) . '-' . strtoupper(Str::random(4));

        /** Creamos el producto */
        $product = Product::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description
        ]);

        /** Unimos el producto con sus categorias */
        $product->categories()->attach([$request->category, $request->subcategory]);



        $this->imageService->upload($request->file('image1'), $product);

        $this->imageService->upload($request->file('image2'), $product);

        //** Creamos tarifas */
        foreach ($request->rates as $rate) {
            Rate::create([
                'price' =>  $rate['price'],
                'start_date' => $rate['start_date'],
                'end_date' => $rate['end_date'],
                'product_id' => $product->id,
            ]);
        }

        /** Volvemos */
        return back()->with('success', 'Producto creado correctamente');
    }

    /**
     * 
     * 
     */



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
        /** Encontramos el producto con todas sus relaciones */
        $product = Product::with('categories', 'rates', 'images')->find($id);

        if (request()->wantsJson()) {
            return response()->json($product);
        }

        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

        $request->validate([
            'name' => 'required|max:255|min:4|unique:products,name,' . $id,
            'description' => 'required|max:500',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:categories,id',
            'rates' => 'required|array|min:1',
            'rates.*.price' => 'required|numeric|min:0',
            'rates.*.start_date' => 'required|date',
            'rates.*.end_date' => 'required|date|after:rates.*.start_date',
            'subcategories' => 'required|array|min:1',
            'subcategories.*' => 'exists:categories,id',
        ]);


        $product = Product::find($id);
        $oldPath = $this->imageService->makePath($product);


        $product->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);


        /** Actualizamos categorias */
        $product->categories()->sync(array_merge(
            [$request->category],      // padre
            $request->subcategories    // checkboxes (incluye el seleccionado + extras)
        ));

        /** regorganizamos rutas y imagenes */
        $this->imageService->reorganize($product, $oldPath);



        /** Eliminamos antiguas tarifas */
        Rate::where('product_id', $product->id)->delete();

        //** Creamos tarifas nuevas (sobreescribimos)*/
        foreach ($request->rates as $rate) {
            Rate::create([
                'price' =>  $rate['price'],
                'start_date' => $rate['start_date'],
                'end_date' => $rate['end_date'],
                'product_id'  => $product->id
            ]);
        }

        /** Volvemos */
        return back()->with('success', 'Producto editado correctamente');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
