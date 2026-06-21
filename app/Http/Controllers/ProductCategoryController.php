<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}


    public function edit(int $id)
    {
        $product = Product::with('categories')->find($id);

        $categories = Category::all();

        return view('products.categories.edit', compact('product', 'categories'));
    }


    public function update(Request $request, string $productID)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:categories,id',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:categories,id',
        ]);

        $product = Product::findOrFail($productID);

        

        

        /** Calculamos new path */
        $newPath = $product->code . '/' . 

        /** Actualizamos categorias */
        $product->categories()->sync(array_merge(
            [$request->category, $request->subcategory],
            $request->subcategories ?? []
        ));

       

        return redirect()->route('products.edit', $productID)->with('success', 'Categorías actualizadas correctamente');
    }
}
