    <!-- Nama : Abdul Ghoni -->
    <!-- NRP : 5026231109 -->
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

    <div class="mobile-view">

        <!-- Header -->
        <header class="rating-header">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="header-title">Rating & Reviews</h5>
        </header>

        <!-- Tabs: Product / Store -->
        <div class="nav-tabs-container">
            <a href="#" class="nav-tab-item active">Product</a>
            <a href="#" class="nav-tab-item">Store</a>
        </div>

        <main class="content-area">
            
            <!-- Product Image -->
            <img src="{{ asset('images/products/' . ($product->product_picture ?? 'default.png')) }}" 
                 class="img-fluid product-main-image" 
                 alt="{{ $product->name_product }}" 
                 onerror="this.src='https://via.placeholder.com/400x300'">

            <!-- Product Info with Price -->
            <div class="product-info-section">
                <div class="product-details">
                    <h4 class="product-name">{{ $product->name_product }}</h4>
                    <div class="rating-summary">
                        <i class="bi bi-star-fill text-warning"></i>
                        {{ number_format($product->reviews->avg('rating') ?? 0, 1) }} Product Rating ({{ $product->reviews->count() }})
                    </div>
                </div>
                <div class="product-price-box">
                    <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <nav class="nav nav-pills gap-2 review-filters">
                    <a class="nav-link active" href="#">All</a>
                    <a class="nav-link" href="#">With Photos</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 5
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 4
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-star-fill text-warning"></i> 3
                    </a>
                </nav>
            </div>
            
            <!-- Review List -->
            <div class="review-list">
                @forelse($reviews as $review)
                <div class="review-card">
                    <div class="review-header-section">
                        <div class="user-info">
                            <i class="bi bi-person-circle user-icon"></i>
                            <div>
                                <h6 class="user-name">{{ $review->user->username ?? 'Anonymous' }}</h6>
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="like-count">
                            ({{ $review->like_review ?? 0 }}) <i class="bi bi-hand-thumbs-up"></i>
                        </div>
                    </div>
                    
                    <p class="review-text">{{ $review->comment }}</p>
                    
                    @if($review->rating >= 5)
                    <div class="review-photos">
                        <img src="https://images.unsplash.com/photo-1623595118745-64b49c2052c7?w=100" alt="review">
                        <img src="https://images.unsplash.com/photo-1621996346565-e326e7e248e2?w=100" alt="review">
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center mt-5 text-muted">
                    <p>Belum ada ulasan untuk produk ini.</p>
                </div>
                @endforelse
            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
