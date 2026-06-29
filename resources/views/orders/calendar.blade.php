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

            {{-- Formulario de edicion --}}
            <div class="card shadow-sm mt-3 " id="edit-order" hidden>

                <div class="card-body">
                    <h6 class="card-title mb-3"> Editar Pedido</h6>

                    <form id="edit-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <select name="product_id" id="edit-producto" class="form-select">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="order_date" id="edit-fecha">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unidades</label>
                            <input type="text" class="form-control" name="units" id="edit-unidades">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">Guardar cambios</button>

                    </form>
                    <form id="delete-form" method="POST" onsubmit="return confirm('¿Eliminar?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Eliminar</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/calendar.js');
@endpush
