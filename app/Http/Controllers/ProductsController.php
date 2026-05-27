<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductsController extends Controller
{
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

        if (request()->wantsJson()) {
            return response()->json($categories);
        }

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

        $category = Category::find($request->category);
        $subcategory = Category::find($request->subcategory);

        /** Creamos la ruta de imagenes */
        $path = $category->name . '/' . $subcategory->name;

        /** Creamos el producto */
        $product = Product::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description
        ]);

        /** Unimos el producto con sus categorias */
        $product->categories()->attach([$request->category, $request->subcategory]);

        /** Funcion privada que gestiona directorios de imagenes */
        $this->handleDirectory($request->file('image1'), $request->file('image2'), $path, $product->id);

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
     * Gestiona el directorio de imágenes 
     * @param UploadedFile $image1 - Imagen principal (obligatoria)
     * @param UploadedFile|null $image2 - Imagen secundaria (opcional)
     * @param string $path - Ruta 
     * @param int $id - ID 
     */
    private function handleDirectory(UploadedFile $image1, ?UploadedFile $image2, string $path, int $id): void
    {
        /** Apuntamos carpeta destino */
        $dest = public_path($path);

        /** En caso de que no exista crearemos el directorio */
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        /** Nombre único */
        $name1 = uniqid() . '.' . $image1->getClientOriginalExtension();

        /** Ponemos las imagenes */
        $image1->move($dest, $name1);

        /** guaradamos nombres de rutas */
        ProductsImage::create([
            'path' => $path . '/' . $name1, // Guardamos "lacteos/quesos/nombre.jpg" en la BD
            'product_id' => $id
        ]);

        /** Opcional */
        if ($image2) {
            $name2 = uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move($dest, $name2);

            ProductsImage::create([
                'path' => $path . '/' . $name2,
                'product_id' => $id
            ]);
        }
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
}
