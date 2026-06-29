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
     * Creacion de una imagen de producto
     * @param $request
     * @param $productId
     */
    public function store(Request $request, int $productId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($productId);


        $this->imageService->upload($request->file('image'), $product->code, $productId);

        return back()->with('success', 'Imagen creada correctamente');
    }



    /**
     * Ediciones de imagenes
     * @param $id
     */
    public function edit(string $id)
    {
        /** Obtenemos producto con imagenes */
        $product = Product::with('images')->find($id);

        return view('products.images.edit', compact('product'));
    }

    /**
     * Remplazar imagen
     */
    public function override(Request $request, int $productId, string $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($productId);

   

        $this->imageService->replace($id, $request->file('image'), $product->code, $productId);

        return back()->with('success', 'Imagen reemplazada correctamente');
    }

    /**
     * Eliminar imagen
     * @param $id
     */
    public function destroy(string $id)
    {
        $this->imageService->delete($id);

        return back()->with('success', 'Imagen eliminada correctamente');
    }
}
