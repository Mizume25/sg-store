<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use App\Models\Rate;
use App\Services\ImageService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    /**
     * Vista a edicion de categorias de producto
     */
    public function edit(int $id)
    {
        $product = Product::with('categories')->find($id);

        $categories = Category::all();

        return view('products.categories.edit', compact('product', 'categories'));
    }


    /**
     * Actualizacion de categorias de producto
     */
    public function update(Request $request, string $productID)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:categories,id',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:categories,id',
        ]);

        $product = Product::findOrFail($productID);

        /** Actualizamos categorias */
        $product->categories()->sync(array_merge(
            [$request->category, $request->subcategory],
            $request->subcategories ?? []
        ));

       

        return redirect()->route('products.edit', $productID)->with('success', 'Categorías actualizadas correctamente');
    }



}
