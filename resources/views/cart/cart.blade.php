{{-- resources/views/cart.blade.php --}}

<!--Name: Muhammad Fikri Khalilullah
NRP: 50262311198
Class: PPPL C
-->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: #FFF5F7;
        }

        .cart-header {
            font-size: 22px;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .cart-list {
            max-height: 70vh;
            overflow-y: auto;
            padding-bottom: 100px;
        }

        .cart-card {
            background: white;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .cart-img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .floating-purchase-btn {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 85%;
            background: #E66A7F;
            color: white;
            padding: 14px;
            font-size: 18px;
            text-align: center;
            border-radius: 15px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0,0,0,0.18);
        }

        .price-text {
            color: #F06570;
            font-weight: 700;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">

    <div class="cart-header">Your Cart</div>

    {{-- CART ITEMS LIST --}}
    <div class="cart-list">
        @forelse ($cartItems as $item)
            <div class="cart-card">
                
                {{-- PRODUCT IMAGE --}}
                <img src="{{ asset('images/products/'.$item->product->product_picture) }}"
                     class="cart-img"
                     onerror="this.src='https://placehold.co/90x90?text=Item';">

                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $item->product->name_product }}</h5>

                    <div class="price-text mb-1">
                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                    </div>

                    <div class="text-muted">
                        Qty: {{ $item->quantity }}
                    </div>
                </div>

            </div>
        @empty
            <p class="text-center text-muted mt-5">Your cart is empty</p>
        @endforelse
    </div>

</div>

{{-- FLOATING PURCHASE BUTTON --}}
@if(count($cartItems) > 0)
    <a href="{{ route('payment.index') }}" class="floating-purchase-btn text-decoration-none">
        Purchase • Rp {{ number_format($totalPrice, 0, ',', '.') }}
    </a>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
