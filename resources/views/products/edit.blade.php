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



    <div class="d-flex justify-content-center">
        <div class="card w-50">
            <div class="card-body">
                <form action={{ route('products.update', $product->id) }} method="POST" enctype="multipart/form-data">
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
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                            @foreach ($product->categories as $category)
                                <span class="badge bg-secondary fs-6">{{ $category->name }}</span>
                            @endforeach
                            <a href="{{ route('products.categories.edit', $product->id) }}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </a>
                        </div>
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


                    {{-- Botones --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">Editar</button>
                        <a href={{ route('products.images.edit', $product->id) }} class="btn btn-secondary btn-lg">Editar
                            Imagenes</a>
                    </div>


                </form>
            </div>
        </div>
    </div>



@endsection

@section('js')
    @vite('resources/js/products.js');
@endsection
