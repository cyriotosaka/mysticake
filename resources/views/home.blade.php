<!DOCTYPE html>
<html lang="id">
<!-- Updated by Okky Priscila_168 - Menambahkan redirect ke top up page -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @include('partials.theme-script')
</head>
<body>

    <div class="container px-3">

        <div class="brand-header pt-3 text-center">
            <img src="{{ asset('images/text_logo.png') }}" alt="MYstiCake" style="height: 30px; width: auto;">
        </div>

        <div class="user-info-row">
            <div class="profile-left">
                
                <a href="{{ route('settings.profile') }}" class="text-decoration-none">
                    
                    <div class="avatar-circle">
                        @php
                            $photo = Auth::user()->profile_picture; 
                        @endphp

                        @if($photo)
                            {{-- Tambahkan style width, height, dan object-fit: cover --}}
                            <img src="{{ asset($photo) }}?v={{ time() }}" 
                                alt="Profile" 
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{-- Icon putih jika tidak ada foto --}}
                            <i class="bi bi-person-fill text-white fs-4"></i>
                        @endif
                    </div>

                </a>

                <div class="user-details">
                    <div class="username">
                        {{ Auth::user()->username }}
                        <a href="{{ route('settings.profile') }}" class="text-dark ms-1">
                            <i class="bi bi-pencil-square" style="font-size: 12px; color: #888;"></i>
                        </a>
                    </div>
                    
                    <!-- Updated by Okky Priscila_168 - Menambahkan redirect ke top up page -->
                    <div class="balance">
                        <i class="bi bi-coin coin-icon"></i>
                        {{ number_format($user->wallet->saldo_coin ?? 0, 0, ',', '.') }}
                        <a href="{{ route('topup.coin') }}" class="plus-icon-link">
                            <i class="bi bi-plus-circle plus-icon"></i>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="cart-right text-decoration-none">
                <i class="bi bi-cart-fill cart-icon"></i>
                @if($cartCount > 0)
                    <div class="cart-badge">{{ $cartCount }}</div>
                @endif
            </a>
        </div>

        <a href="{{ route('search') }}" class="search-container text-decoration-none">
            <i class="bi bi-search search-icon-left"></i>
            <span class="search-input">Search</span>
        </a>

        <div class="banner-section">
            <div class="banner-overlay">
                <h2>ALL DESSERT</h2>
                <h1>SALE</h1>
            </div>

            <i class="bi bi-chevron-left slider-arrow left"></i>
            <i class="bi bi-chevron-right slider-arrow right"></i>

            <img src="{{ asset('images/banner_sale.png') }}" alt="Sale Banner" class="banner-img"
                 onerror="this.src='https://placehold.co/600x250/F06292/FFF?text=Banner'">
        </div>

        <div class="section-title">Recommendation</div>

        @foreach($recommendations as $product)
        <a href="{{ route('product.detail', $product->id_product) }}">
            <div class="card-custom">
                <img src="{{ asset(ltrim('images/products/'.$product->product_picture, '/')) }}" class="card-img" alt="{{ $product->name_product }}"
                     onerror="this.src='https://placehold.co/100?text=Cake'">

                <div class="card-info">
                    <h3>{{ $product->name_product }}</h3>

                    <div class="rating">
                        <i class="bi bi-star-fill star"></i>
                        {{ number_format($product->reviews_avg_rating ?? 0, 1) }}

                        <span class="ms-1" style="color: #666; font-weight: normal;">
                            (dirating oleh {{ $product->reviews_count ?? 0 }})
                        </span>
                    </div>

                    <div style="font-size: 14px; font-weight: 700; color: #F06A7D; margin-top: 4px;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </a>
        @endforeach

        <div class="feature-card">
            <div class="feature-title">NEW FEATURES</div>
            <div class="feature-subtitle">coming soon</div>
        </div>

    </div>

    <div class="bottom-nav-container">
        {{-- Form Logout menggunakan method POST --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
            @csrf
        </form>

        {{-- Tombol/Ikon yang memicu submit form --}}
        <a href="#" class="nav-icon" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-door-open-fill" style="color: #E66A7F;"></i>
        </a>

        <a href="{{ route('gacha.index') }}" class="mystery-box-wrapper text-decoration-none">
            <img src="{{ asset('images/mystery_box.png') }}" class="mystery-box-img" alt="Mystery Box">
            <div class="mystery-text">Mystery Box</div>
        </a>

        <a href="#" class="nav-icon">
             <i class="bi bi-chat-text-fill" style="color: #E66A7F;"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil data user yang sedang login dari PHP
        const currentUser = {
            email: "{{ Auth::user()->email }}",
            username: "{{ Auth::user()->username }}",
            avatar: "{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : '' }}" 
        };

        // 2. Ambil history lama dari LocalStorage browser
        let history = JSON.parse(localStorage.getItem('mysticake_login_history')) || [];

        // 3. Hapus data user ini dari list lama (biar tidak duplikat)
        history = history.filter(user => user.email !== currentUser.email);

        // 4. Masukkan user
        history.unshift(currentUser);

        // 5. Simpan kembali ke browser
        localStorage.setItem('mysticake_login_history', JSON.stringify(history));
    });
    </script>
</body>
</html>
