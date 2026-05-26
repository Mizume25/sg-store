@extends('layouts.app')
@section('content')
    <h1 class="mb-3">Crear Producto</h1>
    {{-- Mensaje de Creacion exitosa --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <div class="card w-50">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    {{-- Campo Nombre Producto --}}
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>

                    {{-- Descripcion --}}
                    <div class="mb-3">
                        <x-input-label for="description" :value="__('Descripcion')" />
                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                    </div>

                    {{-- Categoria Padre --}}
                    <div class="mb-3">
                        <x-input-label for="category" :value="__('Categoria Padre')" />
                        {{-- Selecionas las categorias  padre --}}
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
                        <x-input-label for="category" :value="__('Subcategorias')" />
                        {{-- Selecionas las categorias  padre --}}
                        <select name="category" id="subcategory" class="form-select cursor-pointer">

                        </select>
                    </div>


                    {{-- Tarifas --}}
                    <div class="mb-4">
                        <x-input-label :value="__('Tarifas')" />
                        <small class="text-muted d-block mb-2">Requiere mínimo una tarifa reglamentaria</small>

                        <div id="rates-container">
                            <div class="row g-2 mb-2 rate-item" id="rate-0">
                                <div class="col">
                                    <input type="number" class="form-control" name="rates[0][price]" placeholder="Precio €"
                                        step="0.01" min="0" required>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" name="rates[0][start_date]" required>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" name="rates[0][end_date]" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row gap-3 justify-content-start">

                            <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-rate">
                                <i class="bi bi-plus-circle"></i> Añadir tarifa
                            </button>

                            <button type="button" class="btn btn-outline-dark btn-sm mt-2" id="remove-rate">
                                <i class="bi bi-dash-circle"></i> Quitar tarifa
                            </button>
                        </div>

                    </div>

                    <div class="mb-3">
                        <x-input-label :value="__('Imágenes')" />
                        <small class="text-muted d-block mb-2">Máximo 2 imágenes</small>

                        <div class="d-flex gap-2">
                            <input type="file" class="form-control" name="image1" accept="image/*" required>
                            <input type="file" class="form-control" name="image2" accept="image/*">
                        </div>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-lg">Crear</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    @vite('resources/js/products.js');
@endsection
