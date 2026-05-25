@extends('layouts.app')

@section('content')
    <div class="row g-3">
        {{-- Grid para los card de productos --}}
        <div class="col-8">
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
                    <p>Selecciona un producto</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    @vite('resources/js/dashboard.js');
@endsection
