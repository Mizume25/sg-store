<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
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
        /** Obtenemos todas las categorias padre  */
        $categories  = Category::all();

        /** y lo cargamos a la lista  */
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validamos datos */
        $request->validate([
            'name' => 'required|max:255|min:4|unique:categories,name',
            'category' => 'nullable|exists:categories,id',
            'description' => 'required|max:500',
        ]);

        /** Creamos el codigo  */
        $code = strtoupper(substr($request->name, 0, 3)) . '-' . strtoupper(Str::random(4));

        /** Creamos Categoria */
        Category::create([
            'name' => strtolower($request->name),
            'code' => $code,
            'description' => $request->description,
            'parent_id' => $request->category ?? null

        ]);



        return back()->with('success', 'Categoría creada correctamente');
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
        /** Obtenemos todas las categorias */
        $categories = Category::all();

        /** Obtenemos todas las categorias si es padre filtramos sus hijos y si no su padre */
        if (Category::findOrFail($id)->parent_id == null) {
            $category = Category::with('childrens')->findOrFail($id);
        } else {
            $category = Category::with('parent')->findOrFail($id);
        }

        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255|min:4|unique:categories,name,' . $id,
            'description' => 'required|max:500',
            'category' => 'nullable|exists:categories,id',
        ]);

        // Encontramos la categoria a modificar
        $category = Category::findOrFail($id);

        // Modificamos cambios del formulario
        $category->update([
            'name' => strtolower($request->name),
            'description' => $request->description,
            'parent_id' => $request->category ?? null
        ]);


        //retornamos
        return back()->with('success', 'Categoría modificada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $category = Category::findOrFail($id);
        
        //Borramos hijas
        if($category->paren_id == null ){
            Category::where('parent_id', $category->id)->delete();

        }

        //Borramos categorias
        $category->delete();

         //retornamos
        return back()->with('success', 'Categoría borradas correctamente');
    }
}
