{{-- Extendermos la plantilla --}}
@extends('adminlte::page')

@section('title', 'Crear Categoria')

@section('content_header')
    <h1>Crear Nueva Categoria </h1>

@endsection

@section('content')
    <form action="">
        @csrf

        {{--  Campo  Nombre --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{--  Seleccion de categoria padre --}}
        <div>
            <x-input-label for="parent_id" :value="__('Categoria Padre')" />
            <select name="parent_id" id="parent_id" class="pr-5">
                <option value="">Nueva Categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{--  Descripcion --}}

    </form>

@endsection
