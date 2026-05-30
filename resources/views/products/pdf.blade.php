<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        .badge {
            background: #6c757d;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            margin-right: 4px;
            font-size: 12px;
        }

        .rate-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #eee;
        }

        img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }

        hr {
            border: 1px solid #eee;
        }
    </style>
</head>

<body>

    <h4>{{ $product->name }}</h4>
    <p class="text-muted">{{ $product->code }}</p>
    <p>{{ $product->description }}</p>

    <hr>

    <p><strong>Categorías</strong></p>
    @foreach ($product->categories as $category)
        <span class="badge">{{ $category->name }}</span>
    @endforeach

    <hr>

    <p><strong>Tarifas</strong></p>
    @foreach ($product->rates as $rate)
        <div class="rate-item">
            <<span>{{ $rate->start_date }} - {{ $rate->end_date }}</span>
            <strong>{{ $rate->price }}€</strong>
        </div>
    @endforeach
</body>

</html>
