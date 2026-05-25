@php
    /** Iteraremos los campos */
    $items = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi bi-speedometer2'],
        ['label' => 'Gestionar Categorias', 'route' => 'categories.create', 'icon' => 'bi bi-tags'],
    ];
@endphp


<div class="d-flex flex-column text-white" style="min-width: 220px; min-height: 100vh; background-color:rgb(145, 107, 59)">
    
    {{-- Logo --}}
    <div class="p-3 border-bottom border-secondary" style="background-color: rgba(121, 74, 4, 0.996)">
        <span class="fw-bold fs-5">SG Store</span>
    </div>

    {{-- Menu --}}
    <nav class="flex-grow-1 p-2">
        <ul class="nav flex-column">
            @foreach ($items as $item)
                <li class="nav-item hover:bg-white/10 transition-transform duration-200 hover:scale-105 mb-3" >
                <a href="{{ route($item['route']) }}" class="nav-link text-white">
                   <i class="{{ $item['icon']}}"></i>  {{ $item['label'] }}
                </a>
            </li>
            @endforeach
        </ul>
    </nav>

</div>