@extends('layouts.app')

@section('content')
    <div class="row">
        {{-- Calendario --}}
        <div class="col-8">
            <div id="calendar"></div>
        </div>

        {{-- Formulario --}}
        <div class="col-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Pedido</h5>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <select name="product_id" class="form-select" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha del pedido</label>
                            <input type="date" name="order_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unidades</label>
                            <input type="number" name="units" class="form-control" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Crear pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @vite('resources/js/calendar.js')
@endsection