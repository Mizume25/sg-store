@extends('layouts.app')
@section('content')
    <h1 class="mb-3">Editar Producto</h1>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Mensaje de Creacion exitosa --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif



    <div class="d-flex justify-content-center" data-product="{{ json_encode($product) }}">
        <div class="card w-50">
            <div class="card-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Campo Nombre Producto --}}
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="form-control w-100" type="text" name="name"
                            :value="old('name', $product->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Codigo  Producto --}}
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Codigo')" />
                        <x-text-input id="name" class="form-control w-100" type="text" name="code"
                            :value="old('name', $product->code)" required autofocus disabled />
                    </div>

                    {{-- Descripcion --}}
                    <div class="mb-3">
                        <x-input-label for="description" :value="__('Descripcion')" />
                        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Categoria Padre --}}
                    <div class="mb-3">
                        <x-input-label for="description" :value="__('Categorias')" />
                        @foreach ($product->categories as $category)
                            <span class="badge bg-secondary me-2 fs-6">{{ $category->name }}</span>
                        @endforeach
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle"
                            data-bs-toggle="modal" data-bs-target="#categoryModal"
                            style="width:28px; height:28px; padding:0">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>

                    {{-- Rates --}}
                    <div class="mb-3" id="rates-container">
                        @foreach ($product->rates as $index => $rate)
                            <div class="row g-2 mb-2 rate-item" id="rate-{{ $index }}">
                                <div class="col">
                                    <input type="number" name="rates[{{ $index }}][price]"
                                        value="{{ $rate->price }}">
                                </div>
                                <div class="col">
                                    <input type="date" name="rates[{{ $index }}][start_date]"
                                        value="{{ $rate->start_date }}">
                                </div>
                                <div class="col">
                                    <input type="date" name="rates[{{ $index }}][end_date]"
                                        value="{{ $rate->end_date }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-row gap-3 justify-content-start mb-3">

                        <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-rate">
                            <i class="bi bi-plus-circle"></i> Añadir tarifa
                        </button>

                        <button type="button" class="btn btn-outline-dark btn-sm mt-2" id="remove-rate">
                            <i class="bi bi-dash-circle"></i> Quitar tarifa
                        </button>
                    </div>


                    {{-- Imagenes actuales --}}
                    <div class="row row-cols-2 row-cols-md-4 g-2">
                        @foreach ($product->images as $image)
                            <div class="col">
                                <img src="/{{ $image->path }}" class="img-thumbnail w-100 cursor-pointer"
                                    style="object-fit: cover; height: 120px">
                            </div>
                        @endforeach
                        <div class="col">
                            <label
                                class="img-thumbnail w-100 d-flex align-items-center justify-content-center border-black "
                                style="height: 120px; cursor: pointer; border-style: dashed;">
                                <i class="bi bi-plus fs-1"></i>
                                <input type="file" name="new_image" accept="image/*" class="d-none">
                            </label>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-lg">Crear</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- Modal --}}
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Categoria Padre --}}
                    <div class="mb-3">
                        <x-input-label for="category" :value="__('Categoria Padre')" />
                        <select name="category" id="category" class="form-select cursor-pointer">
                            @foreach ($categories as $category)
                                @if ($category->parent_id == null)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Subcategoria --}}
                    <div class="mb-3">
                        <x-input-label for="subcategory" :value="__('Subcategorias')" />
                        <select name="subcategory" id="subcategory" class="form-select cursor-pointer">
                        </select>
                    </div>


                    <div id="subcategories">
                        
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Aplicar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @vite('resources/js/products.js');
@endsection
