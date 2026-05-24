{{-- Extendermos la plantilla --}}
@extends('adminlte::page')

@section('title', 'Crear Categoria')

@section('content_header')
    <h1>Crear Nueva Categoria </h1>

@endsection

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card w-50">
            <div class="card-body">
                <form action="">
                    @csrf
                    {{--  Campo  Nombre --}}
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" />
                        <br>
                        <x-text-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{--  Seleccion de categoria padre --}}
                    <div class="mb-3">
                        <x-input-label for="parent_id" :value="__('Categoria Padre')" />
                        <br>
                        <select name="parent_id" id="parent_id" class="pr-5">
                            <option value="">Nueva Categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div class="mb-3">

                    {{--  Descripcion --}}
                    <div class="mb-3">
                        <x-input-label for="parent_id" :value="__('Descripcion')" />
                        <br>
                        <textarea name="description" id="description" cols="40" rows="5">

                </textarea>

                        <x-primary-button class="ms-3 bg-black btn btn-primary btn-lg">
                            {{ __('Crear') }}
                        </x-primary-button>

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCategorias">
                            Ver categorías existentes
                        </button>


                    </div>
            </div>
        </div>
    </div>

    </form>


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
