@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                {{-- Campo Nombre --}}
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Categoria Padre --}}
                <div class="mb-3">
                    <x-input-label for="parent_id" :value="__('Categoria Padre')" />
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">Nueva Categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Descripcion --}}
                <div class="mb-3">
                    <x-input-label for="description" :value="__('Descripcion')" />
                    <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-lg">Crear</button>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCategorias">
                        Ver categorías existentes
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modalCategorias" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Categorías existentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($categories as $category)
                        <li class="list-group-item">{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection