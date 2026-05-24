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
        $code = strtoupper(substr($request->name, 0, 3)). '-' . strtoupper(Str::random(4));
        $parent = null;

        if($request->category){
            $parent  = Category::where('name', $request->category)->first();
        } 

        /** Creamos Categoria */
        Category::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'parent_id' => $parent?->id 

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
