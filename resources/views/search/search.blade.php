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

        <form action="{{ route('search.submit') }}" method="POST" class="search-bar-wrapper">
            @csrf
            <i class="bi bi-search search-icon-input"></i>
            <input type="text" name="q" class="search-input-field" placeholder="Type here" value="{{ $query ?? '' }}" autocomplete="off">
        </form>
    </div>

    <h2 class="section-title">Highest Rating</h2>
    <p class="section-subtitle">Ads</p>

    <div class="horizontal-scroll-container">
        @foreach($highestRated as $product)
        <a href="{{ route('product.detail', $product->id_product) }}" class="card-rating">
            <img src="{{ asset('images/products/' . ($product->product_picture ?? 'default.png')) }}" onerror="this.src='https://via.placeholder.com/200x140'">
            <div class="card-content">
                <div class="card-title-h">{{ Str::limit($product->name_product, 35) }}</div>
                <div class="card-meta">3.5 km</div>
                <div class="rating-info">
                    <i class="bi bi-star-fill rating-star"></i> {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="recent-container">
        <h2 class="section-title" style="margin-left: 0; margin-bottom: 15px;">Recently search</h2>
        <div class="recent-tags">
            @foreach($recentSearches as $tag)
                <form action="{{ route('search.submit') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="q" value="{{ $tag }}">
                    <button type="submit" class="tag-item">{{ $tag }}</button>
                </form>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
