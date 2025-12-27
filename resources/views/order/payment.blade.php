<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')
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
        <i class="bi bi-receipt-cutoff"></i> Payment Summary
    </div>
    <div class="summary-row">
        <span class="summary-label">Total Price</span>
        <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>
    <div class="summary-row">
        <span class="summary-label">Delivery Charges</span>
        <span class="summary-value">Rp {{ number_format($deliveryCharge, 0, ',', '.') }}</span>
    </div>
    <div class="total-row">
        <span>Total Payment</span>
        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
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
        <button type="submit" id="mainPurchaseBtn" class="purchase-btn" 
                @if(!$address || !$delivery || !$paymentMethod) disabled @endif>
            Purchase
        </button>
    </form>
    </div>
</div>

<div class="modal fade" id="pinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" style="max-width: 350px;">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <div class="modal-body text-center p-4">
                <h5 class="fw-bold mb-3" style="color: #1A1A1A;">Security PIN</h5>
                <p class="text-muted small">Please enter your 6-digit PIN to confirm payment</p>
                <div class="d-flex justify-content-center gap-2 mb-4">
                    @for($i = 0; $i < 6; $i++)
                        <input type="password" class="form-control text-center otp-input" 
                               maxlength="1" pattern="\d*" inputmode="numeric"
                               style="width: 40px; height: 50px; border: 2px solid #FFE5EC; border-radius: 10px;">
                    @endfor
                </div>
                <button type="button" class="purchase-btn w-100" id="confirmPinBtn">Confirm & Pay</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainPurchaseBtn = document.getElementById('mainPurchaseBtn');
        const confirmPinBtn = document.getElementById('confirmPinBtn');
        const pinModal = new bootstrap.Modal(document.getElementById('pinModal'));
        const inputs = document.querySelectorAll('.otp-input');
        
        // Grab payment method name from PHP
        const paymentMethod = "{{ $paymentMethod->name_method ?? 'Cash' }}";

        // 1. Intercept "Purchase" Click
        mainPurchaseBtn.addEventListener('click', function(e) {
            // Only show PIN for non-Cash methods (e.g., E-Wallet, Card)
            if (paymentMethod !== 'Cash') {
                e.preventDefault(); 
                pinModal.show();
            }
        });

        // 2. Auto-focus PIN Inputs
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // 3. Confirm & Submit Form
        confirmPinBtn.addEventListener('click', function() {
            // Show loading state on button
            confirmPinBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';
            confirmPinBtn.disabled = true;
            
            // Submit the actual form
            mainPurchaseBtn.closest('form').submit();
        });
    });
</script>
</body>
</html>
