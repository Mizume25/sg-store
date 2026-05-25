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
                            onclick="showDetail(JSON.parse(this.dataset.product))" style="cursor:pointer">
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
    <script>
        function showDetail(product) {
            const rates = product.rates.map(r =>
                `<li class="list-group-item d-flex justify-content-between">
            <span>${r.start_date} → ${r.end_date}</span>
            <strong>${r.price}€</strong>
        </li>`
            ).join('');

            const categories = product.categories.map(c =>
                `<span class="badge bg-secondary me-1">${c.name}</span>`
            ).join('');


            const route = '/' + product.categories[0] + '/'

            const images = product.images.map((i, index) =>
                `<img src="/storage/${i.path}" 
          class="product-img ${index === 0 ? 'active' : ''}" 
          style="width:100%; border-radius:8px; transition: opacity 0.5s ease;">`
            ).join('');

            document.getElementById('detail-panel').innerHTML = `
        <div class="card-body">
            <h4>${product.name}</h4>
            <p class="text-muted small">${product.code}</p>
            <p>${product.description || 'Sin descripción'}</p>
            <hr>
            <p class="fw-bold mb-1">Categorías</p>
            <div class="mb-3">${categories}</div>
            <p class="fw-bold mb-1">Precios</p>
            <ul class="list-group">${rates}</ul>
        </div>
    `;
        }
    </script>
@endsection
