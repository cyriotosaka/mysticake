<!-- Nama : Abdul Ghoni -->
<!-- NRP : 5026231109 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name_product }} - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>

    <div class="mobile-container">

        <div class="header-nav">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span class="brand-text">MYstiCake</span>
            <div style="width: 20px;"></div> </div>

        <div class="product-image-wrapper">
            <img src="{{ $product->product_picture ? asset('images/products/'.$product->product_picture) : 'https://placehold.co/400x400/F06A7D/white?text=No+Image' }}"
                 alt="{{ $product->name_product }}">
        </div>

        <div class="rating-section">
            <a href="{{ route('product.ratings', $product->id_product) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; flex-grow: 1;">
                <span class="rating-score">{{ number_format($avgRating, 1) }}</span>
                <i class="fas fa-star star-icon"></i>
                <span class="review-count">Product Reviews ({{ $totalReviews }})</span>
            </a>
            
            <form action="{{ route('cart.add', $product->id_product) }}" method="POST" style="display: inline; margin: 0;">
                @csrf
                <button type="submit" class="cart-btn" style="background: none; border: none; cursor: pointer; padding: 5px;">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </form>
        </div>


        <h1 class="product-title">{{ $product->name_product }}</h1>

        <p class="product-desc">
            {{ $product->description }}
        </p>

        <div class="price-row">
            <div class="price-tag">
                RP {{ number_format($product->price, 0, ',', '.') }}
            </div>
            <a href="{{ route('product.ratings', $product->id_product) }}" class="reviews-link">Reviews</a>
        </div>

        <div class="action-bar">
            <form action="{{ route('cart.add', $product->id_product) }}" method="POST" style="flex-grow: 1;">
                @csrf
                <button type="submit" class="btn-order">Order Now</button>
            </form>

            <button class="btn-chat">
                <i class="fas fa-comment-dots"></i>
            </button>
        </div>

    </div>

</body>
</html>
