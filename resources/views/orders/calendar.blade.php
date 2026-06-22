@extends('layouts.app')

@section('content')
    <div class="row">
        {{-- Calendario --}}
        <div class="col-12 col-lg-8 mb-sm-5">
            <div id="calendar"></div>
        </div>

        {{-- Formulario --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Pedido</h5>

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

 @push('scripts')
        @vite('resources/js/calendar.js');
 @endpush
