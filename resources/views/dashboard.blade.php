@extends('layouts.app')

@section('content')
    <div class="row g-3">
        {{-- Grid para los card de productos --}}
        <div class="col-8">
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('products.export') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                </a>
            </div>
            <div class="row g-3" id="product_grid">
                {{-- Iteramos cards --}}
                @foreach ($products as $product)
                    <div class="col-4">
                        <div class="card h-100 cursor-pointer shadow-sm" data-product='@json($product)'
                            style="cursor:pointer">
                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="text-muted small">{{ $product->code }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- Panel derecho - Donde se mostrara el producto --}}
        <div class="col-4">
            <div class="card h-100 shadow-sm" id="detail-panel">
                <div class="card-body d-flex align-items-center justify-content-center text-muted">
                    <div class="card-body" id="select">
                        <div class="mb-3" id="imagenes"></div>
                        <h4 id="name"></h4>
                        <p class="text-muted small" id="code"></p>
                        <p id="description"> </p>
                        <hr>
                        <p class="fw-bold mb-1" id="categories">Categorías</p>

                        <p class="fw-bold mb-1" id="prices">Precios</p>

                        <div class="d-flex gap-2 mt-3 mb-4">
                            <a href='#' class="btn btn-warning btn-sm w-50" id="edit-product">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="#" method="POST" class="w-50" id="delte-product">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>

                            
                        </div>
                        <a href="#" class="btn btn-danger btn-sm " id="pdf-product">
                                <i class="bi bi-file-earmark-pdf"></i> PDF 
                            </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    @vite('resources/js/dashboard.js');
@endsection
