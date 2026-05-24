@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Bienvenido, {{ auth()->user()->name }}</h2>
            <p class="text-muted">Panel de administración de SG Store</p>
        </div>
    </div>
@endsection
