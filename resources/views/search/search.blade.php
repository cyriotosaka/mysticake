<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
</head>
<body>

    <div class="search-header">
        <a href="{{ route('home') }}" class="btn-back"><i class="bi bi-arrow-left"></i></a>

        <form action="{{ route('search') }}" method="GET" class="search-bar-wrapper">
            <i class="bi bi-search search-icon-input"></i>
            <input type="text" name="q" class="search-input-field" placeholder="Type here" value="{{ $query ?? '' }}" autocomplete="off">
        </form>
    </div>

    @if($query)

        <div class="filter-bar">
            <div class="filter-item"><i class="bi bi-sliders"></i> Nearly</div>
            <div class="filter-item">Bintang 4.5+</div>
            <div class="filter-item">Kuliner</div>
        </div>

        <div class="result-list">
            @forelse($results as $product)
            <div class="card-result">
                <div class="result-img-wrapper">
                    <img src="{{ asset(ltrim($product->product_pic, '/')) }}" class="result-img" onerror="this.src='https://via.placeholder.com/100'">
                    <div class="rating-pill">
                        <i class="bi bi-star-fill text-warning me-1"></i> {{ $product->average_rating }}
                    </div>
                </div>
                <div class="result-info">
                    <div class="result-title">{{ $product->name_product }}</div>
                    <div class="result-meta">
                        3.5 km <br> 25-30 menit
                    </div>
                    <div class="result-price">
                        RP {{ number_format($product->price * 15000, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center mt-5 text-muted">
                <img src="https://via.placeholder.com/150x150?text=No+Result" alt="Empty" style="opacity: 0.5; margin-bottom: 20px;">
                <p>Produk tidak ditemukan.</p>
            </div>
            @endforelse
        </div>

    @else

        <h2 class="section-title">Highest Rating</h2>
        <p class="section-subtitle">Ads</p>

        <div class="horizontal-scroll-container">
            @foreach($highestRated as $product)
            <a href="#" class="card-rating text-decoration-none">
                <img src="{{ asset(ltrim($product->product_pic, '/')) }}" onerror="this.src='https://via.placeholder.com/200x140'">
                <div class="card-meta mt-2">3.5 km</div>
                <div class="card-title-h">{{ Str::limit($product->name_product, 25) }}</div>
                <div class="rating-info">
                    <i class="bi bi-star-fill rating-star"></i> {{ $product->average_rating }}
                </div>
            </a>
            @endforeach
        </div>

        <div class="recent-container">
            <h2 class="section-title" style="margin-left: 0; margin-bottom: 20px;">Recently search</h2>
            <div class="recent-tags">
                @foreach($recentSearches as $tag)
                    <a href="{{ route('search', ['q' => $tag]) }}" class="tag-item">{{ $tag }}</a>
                @endforeach
            </div>
        </div>

    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
