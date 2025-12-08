<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #FFFDF5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding-bottom: 100px;
        }

        .page-header {
            font-size: 20px;
            font-weight: 700;
            color: #1A1A1A;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pink-card {
            background: linear-gradient(135deg, #FF8FA3 0%, #FF6B83 100%);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 15px;
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 131, 0.25);
        }

        .card-header {
            font-size: 16px;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .white-button {
            background: white;
            color: #FF6B83;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .white-button:hover {
            background: #FFF5F7;
            color: #FF6B83;
            transform: scale(1.02);
        }

        .address-box {
            background: rgba(255,255,255,0.2);
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .address-text {
            font-size: 14px;
            color: white;
            font-weight: 500;
            margin: 0;
        }

        .delivery-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .delivery-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-grow: 1;
        }

        .delivery-icon {
            font-size: 24px;
        }

        .delivery-text {
            font-size: 15px;
            font-weight: 600;
        }

        .product-list-card {
            padding-top: 8px;
        }

        .product-item {
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .product-qty {
            font-size: 12px;
            color: rgba(255,255,255,0.9);
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: white;
            text-align: right;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            color: white;
        }

        .summary-label {
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
        }

        .total-row {
            border-top: 2px solid rgba(255,255,255,0.3);
            margin-top: 8px;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 16px;
        }

        .payment-method-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-icon {
            font-size: 24px;
        }

        .purchase-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #FFFDF5;
            padding: 15px 20px;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.08);
        }

        .purchase-btn {
            width: 100%;
            background: linear-gradient(135deg, #FF8FA3 0%, #FF6B83 100%);
            color: white;
            padding: 16px;
            font-size: 18px;
            text-align: center;
            border-radius: 25px;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 12px rgba(255, 107, 131, 0.3);
            transition: all 0.2s;
        }

        .purchase-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 131, 0.4);
        }

        .purchase-btn:disabled {
            background: #CCCCCC;
            box-shadow: none;
            cursor: not-allowed;
        }

        .back-btn {
            color: #1A1A1A;
            font-size: 24px;
            text-decoration: none;
        }

        .info-icon {
            color: #FF6B83;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('cart.index') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
            <div class="page-header mb-0">Payment & Delivery Details</div>
        </div>
        <i class="bi bi-info-circle info-icon"></i>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Delivery Address -->
    <div class="pink-card">
        <div class="card-header">
            <i class="bi bi-geo-alt-fill"></i>
            Delivery Address
        </div>
        @if($address)
            <div class="address-box">
                <p class="address-text">{{ $address->full_address }}</p>
                @if($address->address_contact_number)
                    <p class="address-text" style="font-size: 13px; margin-top: 4px;">📞 {{ $address->address_contact_number }}</p>
                @endif
            </div>
        @else
            <div class="address-box">
                <p class="address-text">Please select a delivery address</p>
            </div>
        @endif
        <a href="{{ route('order.address.select') }}" class="white-button">Edit Address</a>
    </div>

    <!-- Delivery Type -->
    <div class="pink-card">
        <div class="card-header">
            <i class="bi bi-bicycle"></i>
            Delivery Type
        </div>
        <div class="delivery-row" style="margin-bottom: 10px;">
            @if($delivery)
                <div class="delivery-info">
                    <div>
                        <div class="delivery-text">{{ $delivery->type }}</div>
                        <div style="font-size: 13px; opacity: 0.9;">Rp {{ number_format($delivery->delivery_charges, 0, ',', '.') }}</div>
                    </div>
                </div>
            @else
                <div class="delivery-info">
                    <div class="delivery-text">Please select delivery method</div>
                </div>
            @endif
            <a href="{{ route('order.delivery') }}" class="white-button">Edit</a>
        </div>
    </div>

    <!-- Order Items -->
    <div class="pink-card product-list-card">
        <div class="card-header">
            <i class="bi bi-bag-fill"></i>
            Enak Dessert
        </div>
        @foreach($items as $item)
            <div class="product-item">
                <img src="{{ asset('images/products/'.$item->product->product_picture) }}"
                     class="product-img"
                     onerror="this.src='https://placehold.co/50x50/FFE5EC/FF6B83?text=Cake';">
                <div class="product-info">
                    <div class="product-name">{{ $item->product->name_product }}</div>
                    <div class="product-qty">Qty: {{ $item->quantity }}</div>
                </div>
                <div class="product-price">
                    {{ number_format($item->product->price * $item->quantity / 1000, 0) }}.000
                </div>
            </div>
        @endforeach
    </div>

    <!-- Payment Summary -->
    <div class="pink-card">
        <div class="card-header">
            <i class="bi bi-receipt-cutoff"></i>
            Payment Summary
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Price</span>
            <span class="summary-value">{{ number_format($subtotal / 1000, 0) }}.000</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Delivery Charges</span>
            <span class="summary-value">{{ number_format($deliveryCharge / 1000, 0) }}.000</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Extra Charges</span>
            <span class="summary-value">0.000</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Discount</span>
            <span class="summary-value">-0.000</span>
        </div>
        <div class="total-row">
            <span>Total Payment</span>
            <span>{{ number_format($total / 1000, 0) }}.000</span>
        </div>
    </div>

    <!-- Payment Method -->
    <div class="pink-card">
        <div class="payment-method-row">
            @if($paymentMethod)
                <div class="payment-info">
                    <i class="bi bi-{{ $paymentMethod->name_method == 'Cash' ? 'cash-stack' : 'credit-card' }} payment-icon"></i>
                    <span class="delivery-text">{{ $paymentMethod->name_method }}</span>
                </div>
            @else
                <div class="payment-info">
                    <i class="bi bi-credit-card payment-icon"></i>
                    <span class="delivery-text">Select payment method</span>
                </div>
            @endif
            <a href="{{ route('order.payment.methods') }}" class="white-button">Change</a>
        </div>
    </div>

    <div style="height: 80px;"></div>

    <!-- Purchase Button -->
    <div class="purchase-section">
        <form action="{{ route('order.process') }}" method="POST">
            @csrf
            <button type="submit" class="purchase-btn" 
                    @if(!$address || !$delivery || !$paymentMethod) disabled @endif>
                Purchase
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
