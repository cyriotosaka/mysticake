<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')

    <style>
        body {
            background: #fdf4f5;
            font-family: 'Poppins', sans-serif;
        }
        .mobile-container {
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        .header-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid #f0e0e3;
        }
        .back-btn {
            color: #E66A7F;
            font-size: 18px;
            text-decoration: none;
        }
        .header-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }
        .wishlist-count {
            font-size: 13px;
            color: #E66A7F;
            font-weight: 600;
        }
        .card-custom {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f5e6e8;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }
        .card-img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
        }
        .card-info {
            flex-grow: 1;
        }
        .card-info h3 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin: 0 0 4px;
        }
        .card-price {
            font-size: 14px;
            font-weight: 700;
            color: #F06A7D;
        }
        .remove-btn {
            background: none;
            border: none;
            color: #ccc;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }
        .remove-btn:hover {
            color: #E66A7F;
        }
        .empty-state {
            text-align: center;
            padding: 64px 32px;
            color: #aaa;
        }
        .empty-state i {
            font-size: 56px;
            color: #f0c8d0;
            margin-bottom: 16px;
        }
        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn-browse {
            background: #E66A7F;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 10px 28px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }
        .alert-success {
            margin: 10px 16px 0;
            font-size: 13px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="mobile-container">

    <div class="header-nav">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Wishlist</span>
        <span class="wishlist-count">{{ $wishlists->count() }} item</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($wishlists->isEmpty())
        <div class="empty-state">
            <i class="bi bi-heart"></i>
            <p>Wishlist kamu masih kosong.<br>Yuk simpan produk favorit kamu!</p>
            <a href="{{ route('home') }}" class="btn-browse">Jelajahi Produk</a>
        </div>
    @else
        @foreach($wishlists as $item)
            @if($item->product)
            <div class="card-custom">
                <a href="{{ route('product.detail', $item->product->id_product) }}" style="display:flex;align-items:center;gap:12px;flex-grow:1;text-decoration:none;color:inherit;">
                    <img src="{{ asset('images/products/' . $item->product->product_picture) }}"
                         class="card-img"
                         alt="{{ $item->product->name_product }}"
                         onerror="this.src='https://placehold.co/75?text=Cake'">
                    <div class="card-info">
                        <h3>{{ $item->product->name_product }}</h3>
                        <div class="card-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                </a>

                <form action="{{ route('wishlist.toggle', $item->product->id_product) }}" method="POST">
                    @csrf
                    <button type="submit" class="remove-btn" title="Hapus dari wishlist">
                        <i class="bi bi-heart-fill" style="color:#E66A7F;"></i>
                    </button>
                </form>
            </div>
            @endif
        @endforeach
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
