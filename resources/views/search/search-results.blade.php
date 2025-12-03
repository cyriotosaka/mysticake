<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
</head>
<body>

    <div class="search-header">
        <a href="{{ route('home') }}" class="btn-back"><i class="bi bi-arrow-left"></i></a>

        <form action="{{ route('search.submit') }}" method="POST" class="search-bar-wrapper">
            @csrf
            <i class="bi bi-search search-icon-input"></i>
            <input type="text" name="q" class="search-input-field" placeholder="Type here" value="{{ $query ?? '' }}" autocomplete="off" autofocus>
        </form>
    </div>

    <div class="filter-bar">
        <div class="filter-item"><i class="bi bi-sliders"></i> Nearly</div>
        <div class="filter-item">Bintang 4.5+</div>
        <div class="filter-item">Kuliner</div>
    </div>

    <div class="result-list">
        @forelse($results as $product)
        <a href="{{ route('product.detail', $product->id_product) }}" class="card-result-link">
            <div class="card-result">
                <div class="result-img-wrapper">
                    <img src="{{ asset('images/products/' . ($product->product_picture ?? 'default.png')) }}" class="result-img" onerror="this.src='https://via.placeholder.com/110'">
                    <div class="rating-pill">
                        <i class="bi bi-star-fill text-warning me-1"></i> 
                        {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}
                    </div>
                </div>
                <div class="result-info">
                    <div class="result-title">{{ $product->name_product }}</div>
                    <div class="result-meta">
                        3.5 km <br> 25-30 menit
                    </div>
                    <div class="result-price">
                        RP {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="text-center mt-5 text-muted">
            <img src="https://via.placeholder.com/150x150?text=No+Result" alt="Empty" style="opacity: 0.5; margin-bottom: 20px;">
            <p>Produk "{{ $query }}" tidak ditemukan.</p>
            <a href="{{ route('search') }}" class="btn btn-sm btn-outline-primary mt-2">Coba Pencarian Lain</a>
        </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
