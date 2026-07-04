@extends('layouts.app')
@section('content')
    <h1 class="mb-3">Crear Categoria</h1>
   

    <div class="d-flex justify-content-center">
        <div class="card w-100 w-lg-50">
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    {{-- Campo Nombre --}}
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>

                    {{-- Categoria Padre --}}
                    <div class="mb-3">
                        <x-input-label for="category" :value="__('Categoria Padre')" />
                        {{-- Selecionas las categorias  padre --}}
                        <select name="category" id="category" class="form-select cursor-pointer">
                            <option value="">Nueva Categoria Padre</option>
                            @foreach ($categories as $category)
                                @if ($category->parent_id == null)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Descripcion --}}
                    <div class="mb-3">
                        <x-input-label for="description" :value="__('Descripcion')" />
                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex flex-column flex-lg-row gap-2">
                        <button type="submit" class="btn btn-dark btn-lg">Crear</button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editCategorias">
                            Editar Categorias
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

  

    {{-- Modal de listas --}}
    <div class="modal fade" id="editCategorias" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorias / Subcategorias existentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center {{ $category->parent_id ? 'ps-4 text-muted fst-italic' : 'fw-bold' }}">
                                {{ $category->name }}
                                <div class="d-flex gap-1">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
