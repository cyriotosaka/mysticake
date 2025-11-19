<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <div class="container px-3">

        <div class="brand-header pt-3">
            <h1>MYstiCake</h1>
        </div>

        <div class="user-info-row">
            <div class="profile-left">
                <div class="avatar-circle">
                    @php
                        $photo = Auth::user()->profile_pic;
                    @endphp

                    @if($photo)
                        <img src="{{ asset($photo) }}?v={{ time() }}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    @else
                        <i class="bi bi-person-fill"></i>
                    @endif
                </div>
                <div class="user-details">
                    <div class="username">
                        {{ Auth::user()->username }}
                        <a href="{{ route('settings.profile') }}" class="text-dark ms-2">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                    <div class="balance">
                        <i class="bi bi-coin coin-icon"></i> 120.000 <i class="bi bi-plus-circle plus-icon"></i>
                    </div>
                </div>
            </div>
            <div class="cart-right">
                <i class="bi bi-cart-fill cart-icon"></i>
                @if($cartCount > 0)
                    <div class="cart-badge">{{ $cartCount }}</div>
                @endif
            </div>
        </div>

        <form action="{{ route('search') }}" method="GET" class="search-container position-relative">
            <i class="bi bi-search search-icon-left"></i>
            <input type="text" name="q" class="form-control search-input" placeholder="Search" onclick="window.location.href='{{ route('search') }}'">
        </form>

        <div class="banner-section">
            <img src="{{ asset('images/banner_sale.png') }}" alt="Sale Banner" class="banner-img">
        </div>

        <div class="section-title">Recommendation</div>

        @foreach($recommendations as $product)
        <div class="card-custom">
            <img src="{{ asset(ltrim($product->product_pic, '/')) }}" class="card-img" alt="{{ $product->name_product }}"
                 onerror="this.src='https://via.placeholder.com/60'">

            <div class="card-info">
                <h3>{{ $product->name_product }}</h3>
                <div class="rating">
                    <i class="bi bi-star-fill star"></i> {{ $product->average_rating }}
                    (dirating oleh {{ $product->review_count }})
                </div>
                <div style="font-size: 14px; font-weight: bold; color: #e91e63; margin-top: 2px;">
                    Rp {{ number_format($product->price * 15000, 0, ',', '.') }} </div>
            </div>
        </div>
        @endforeach

        <div class="feature-card">
            <div class="feature-title">NEW FEATURES</div>
            <div class="feature-subtitle">coming soon</div>
        </div>

    </div>

    <div class="bottom-nav-container">
        <a href="#" class="nav-icon">
            <i class="bi bi-door-open-fill" style="font-size: 28px; color: #C25E75;"></i>
        </a>

        <div class="mystery-box-wrapper">
            <img src="{{ asset('images/mystery_box.png') }}" class="mystery-box-img" alt="Mystery Box">
            <div class="mystery-text">Mystery Box</div>
        </div>

        <a href="#" class="nav-icon">
             <i class="bi bi-chat-text-fill" style="font-size: 28px; color: #C25E75;"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
