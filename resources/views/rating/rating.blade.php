<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating - {{ $product->name_product }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="rating-header">
        <a href="{{ url()->previous() }}" class="btn-back"><i class="bi bi-arrow-left"></i></a>
        <div class="header-title">Rating & Reviews</div>
    </div>

    <!-- Product Info -->
    <div class="product-info-section">
        <img src="{{ asset('images/products/' . ($product->product_picture ?? 'default.png')) }}" class="product-thumb" onerror="this.src='https://via.placeholder.com/60'">
        <div class="product-details">
            <h2>{{ $product->name_product }}</h2>
            <div class="rating-summary">
                <i class="bi bi-star-fill"></i>
                <span style="font-weight: 600; color: #333; margin-right: 5px;">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</span>
                Product Rating ({{ $product->reviews->count() }})
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <button class="filter-btn active">All</button>
        <button class="filter-btn">With Photos</button>
        <button class="filter-btn"><i class="bi bi-star-fill text-warning"></i> 5</button>
        <button class="filter-btn"><i class="bi bi-star-fill text-warning"></i> 4</button>
        <button class="filter-btn"><i class="bi bi-star-fill text-warning"></i> 3</button>
        <button class="filter-btn"><i class="bi bi-star-fill text-warning"></i> 2</button>
        <button class="filter-btn"><i class="bi bi-star-fill text-warning"></i> 1</button>
    </div>

    <!-- Review List -->
    <div class="review-list">
        @forelse($reviews as $review)
        <div class="review-card">
            <div class="review-header">
                <div class="user-profile">
                    <img src="{{ asset($review->user->profile_pic ?? 'images/default-avatar.png') }}" class="user-avatar" onerror="this.src='https://via.placeholder.com/35'">
                    <div class="user-name">{{ $review->user->username ?? 'Anonymous' }}</div>
                </div>
                <!-- Tanggal review tidak ada di database, bisa pakai dummy atau created_at jika ada -->
                <div class="review-date">2 hari lalu</div> 
            </div>

            <div class="review-rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        <i class="bi bi-star-fill"></i>
                    @else
                        <i class="bi bi-star"></i>
                    @endif
                @endfor
            </div>

            <div class="review-text">
                {{ $review->comment }}
            </div>

            <!-- Photos (Dummy logic karena belum ada tabel foto review) -->
            @if($review->rating >= 5) 
            <div class="review-photos">
                <img src="https://via.placeholder.com/80" class="review-photo">
                <img src="https://via.placeholder.com/80" class="review-photo">
            </div>
            @endif

            <div class="review-footer">
                <button class="like-btn">
                    <i class="bi bi-hand-thumbs-up"></i> ({{ $review->like_review ?? 0 }})
                </button>
            </div>
        </div>
        @empty
        <div class="text-center mt-5 text-muted">
            <p>Belum ada ulasan untuk produk ini.</p>
        </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
