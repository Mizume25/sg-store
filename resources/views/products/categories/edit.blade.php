 @extends('layouts.app')

 @section('content')
     <h1 class="mb-3">Editar Categorias de Productos</h1>
     {{-- Mensaje de Creacion exitosa --}}
     @if (session('success'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
     @endif

     <div class="card w-50 mx-auto">
         <div class="card-body" data-id="{{ $product->id }}">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm mb-3">
                     <i class="bi bi-arrow-left"></i> Volver
                 </a>
             <h5 class="card-title mb-4">Gestionar Categorías de {{ $product->name }}</h5>
                
             <form action="{{ route('products.categories.update', $product->id) }}" method="POST" id="editForm">
                 @csrf

                 {{-- Categoria Padre --}}
                 <div class="mb-3">
                     <x-input-label for="category" :value="__('Categoria Padre')" />
                     <select name="category" id="category" class="form-select">
                         @foreach ($categories as $category)
                             @if ($category->parent_id == null)
                                 <option value="{{ $category->id }}">{{ $category->name }}</option>
                             @endif
                         @endforeach
                     </select>
                 </div>

                 {{-- Subcategoria principal --}}
                 <div class="mb-3">
                     <x-input-label for="subcategory" :value="__('Subcategoria')" />
                     <select name="subcategory" id="subcategory" class="form-select">
                     </select>
                 </div>

                 {{-- Subcategorias extra --}}
                 <div class="mb-3">
                     <x-input-label :value="__('Subcategorias adicionales')" />
                     <div id="subcategories"></div>
                 </div>

                 <a id="manage-link" href="#"
                     class="text-decoration-none text-muted small mt-2 d-inline-flex align-items-center gap-1 mb-3">
                     <i class="bi bi-box-arrow-up-right"></i> Crear más subcategorías de
                     <strong id="manage-link-name"></strong>
                 </a>
                 
                 <button type="submit" class="btn btn-dark w-100">Aplicar</button>
             </form>
         </div>
     </div>
 @endsection

 @section('js')
     @vite('resources/js/categories.js');
 @endsection
