@php
    /** Iteraremos los campos */
    $items = [
        ['label' => 'Catalogo', 'route' => 'dashboard', 'icon' => 'bi bi-speedometer2'],
        ['label' => 'Gestionar Categorias', 'route' => 'categories.create', 'icon' => 'bi bi-tags'],
        ['label' => 'Añadir Producto', 'route' => 'products.create', 'icon' => 'bi bi-box-seam'],
        ['label' => 'Calendario', 'route' => 'orders.index', 'icon' => 'bi bi-calendar']
    ];
@endphp


<div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebar"
    aria-labelledby="sidebarLabel"
    style="min-width: 220px; background-color:rgb(145, 107, 59);">

    {{-- Logo --}}
    <div class="offcanvas-header p-3 border-bottom border-secondary" style="background-color: rgba(121, 74, 4, 0.996)">
        <span class="fw-bold fs-5" id="sidebarLabel">SG Store</span>
        {{-- Botón de cierre, solo visible mientras es offcanvas (móvil/tablet) --}}
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
            data-bs-target="#sidebar" aria-label="Close"></button>
    </div>

    {{-- Menu --}}
    <nav class="offcanvas-body flex-column p-2">
        <ul class="nav flex-column w-100">
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