@extends('layouts.app')

@section('content')
 <h1 class="mb-3">Editar Imagenes de {{ $product->name }}</h1>

 {{-- Mensaje de Creacion exitosa --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="mb-3">
        @foreach ($product->images as $image)
            <div class="d-flex align-items-center gap-3 mb-2 p-2 border rounded">
                <img src="/{{ $image->path }}" class="img-thumbnail"
                    style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;">
                <span class="flex-grow-1 text-muted small text-truncate">{{ $image->path }}</span>
                <form action={{ route('products.images.override', [$product->id, $image->id]) }} method="POST"
                    class="d-inline"  enctype="multipart/form-data" >
                    @csrf
                    <label class="btn btn-outline-secondary btn-sm mb-0" style="cursor:pointer">
                        <i class="bi bi-arrow-repeat"></i> Reemplazar
                         <input type="file" name="image" accept="image/*" class="d-none" onchange="this.form.submit()">
                    </label>
                </form>
                <form action={{ route('products.images.destroy', $image->id) }} method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        @endforeach

        {{-- Añadir imagen --}}
        <div class="d-flex align-items-center gap-3 p-2 border rounded mt-2">
            <form action={{ route('products.images.store', $product->id) }} method="POST" enctype="multipart/form-data"
                class="d-flex align-items-center gap-2 w-100">
                @csrf
                <i class="bi bi-image text-muted" style="font-size: 1.5rem; flex-shrink: 0;"></i>
                <span class="flex-grow-1 text-muted small">Selecciona una imagen...</span>
                <label class="btn btn-outline-success btn-sm mb-0" style="cursor:pointer">
                    <i class="bi bi-plus-lg"></i> Añadir
                    <input type="file" name="image" accept="image/*" class="d-none" onchange="this.form.submit()">
                </label>
            </form>
        </div>
    </div>
@endsection
