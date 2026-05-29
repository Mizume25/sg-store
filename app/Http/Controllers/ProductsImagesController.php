<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsImage;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductsImagesController extends Controller
{

    public function __construct(private ImageService $imageService) {}

    /**
     * Creacion de nueva imagen
     */
    public function store(Request $request, int $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,webp|max:2048',
        ]);


        $image = ProductsImage::where('product_id', $id)->first();
        $path = implode('/', array_slice(explode('/', $image->path), 0, 2));

        $this->imageService->upload($request->file('image'), $path, $id);

        return back()->with('success', 'Imagen creada correctamente');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** Obtenemos producto con imagenes */
        $product = Product::with('images')->find($id);

        return view('products.images.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function override(Request $request, string $productId, string $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,webp|max:2048',
        ]);

        $image = ProductsImage::where('product_id', $productId)->first();
        $path = implode('/', array_slice(explode('/', $image->path), 0, 2));

        $this->imageService->replace($id, $request->file('image'), $path, $productId);

        return back()->with('success', 'Imagen reemplazada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->imageService->delete($id);

        return back()->with('success', 'Imagen eliminada correctamente');
    }
}
