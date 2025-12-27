<!--Muhammad Fikri Khalilullah/5026231198-->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')
    <style>
        body {
            background: #F5F5F5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .cart-header {
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0;
            color: #1A1A1A;
        }

        .cart-list {
            max-height: calc(100vh - 220px);
            overflow-y: auto;
            padding-bottom: 20px;
        }

        .cart-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            align-items: center;
            transition: all 0.2s;
        }

        .cart-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .cart-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #E66A7F;
            flex-shrink: 0;
        }

        .cart-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 6px;
        }

        .price-text {
            color: #E66A7F;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1.5px solid #E66A7F;
            background: white;
            color: #E66A7F;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            padding: 0;
        }

        .qty-btn:hover:not(:disabled) {
            background: #E66A7F;
            color: white;
        }

        .qty-btn:disabled {
            border-color: #DDD;
            color: #DDD;
            cursor: not-allowed;
        }

        .qty-display {
            min-width: 20px;
            text-align: center;
            font-weight: 600;
            color: #1A1A1A;
            font-size: 14px;
        }

        .quantity-text {
            color: #999;
            font-size: 14px;
        }

        .btn-delete {
            background: none;
            border: none;
            color: #FF8A9B;
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-left: auto;
        }

        .btn-delete:hover {
            color: #E66A7F;
            transform: scale(1.1);
        }

        .checkout-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
        }

        .subtotal-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .subtotal-label {
            color: #666;
            font-weight: 500;
        }

        .subtotal-amount {
            color: #1A1A1A;
            font-weight: 700;
            font-size: 18px;
        }

        .purchase-btn {
            width: 100%;
            background: #E0E0E0;
            color: white;
            padding: 16px;
            font-size: 17px;
            text-align: center;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }

        .purchase-btn:not(:disabled) {
            background: linear-gradient(135deg, #E66A7F 0%, #D95570 100%);
            box-shadow: 0 4px 12px rgba(230, 106, 127, 0.3);
            cursor: pointer;
        }

        .purchase-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(230, 106, 127, 0.4);
        }

        .purchase-btn:disabled {
            cursor: not-allowed;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-cart i {
            font-size: 64px;
            color: #DDD;
            margin-bottom: 15px;
        }

        .back-btn {
            color: #1A1A1A;
            font-size: 24px;
            text-decoration: none;
        }

        .nav-tabs-container {
            display: flex;
            gap: 8px;
            background: white;
            padding: 6px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .nav-tab {
            flex: 1;
            text-align: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #999;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-tab:hover:not(.active) {
            color: #666;
            background: #F5F5F5;
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #E66A7F 0%, #D95570 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(230, 106, 127, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('home') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        
        <!-- Navigation Tabs in Header -->
        <div class="nav-tabs-container flex-grow-1">
            <div class="nav-tab active">
                My Cart
            </div>
            <a href="{{ route('order.history') }}" class="nav-tab" style="text-decoration: none;">
                History
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        
        <div class="cart-list">
            @forelse ($items as $item)
                <div class="cart-card">
                    <input type="checkbox" class="cart-checkbox item-checkbox" 
                           name="selected_items[]" 
                           value="{{ $item->id_cart_item }}"
                           data-price="{{ $item->product->price }}"
                           data-quantity="{{ $item->quantity }}">
                    
                    <img src="{{ asset('images/products/'.$item->product->product_picture) }}"
                         class="cart-img"
                         onerror="this.src='https://placehold.co/80x80/FFE5EC/E66A7F?text=Cake';">

                    <div class="flex-grow-1">
                        <div class="product-name">{{ $item->product->name_product }}</div>
                        <div class="price-text">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                        
                        <!-- Quantity Controls -->
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn" 
                                    onclick="updateQuantity({{ $item->id_cart_item }}, 'decrease')"
                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                <i class="bi bi-dash"></i>
                            </button>
                            
                            <span class="qty-display">{{ $item->quantity }}</span>
                            
                            <button type="button" class="qty-btn"
                                    onclick="updateQuantity({{ $item->id_cart_item }}, 'increase')">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn-delete" title="Delete item" 
                            data-item-id="{{ $item->id_cart_item }}" 
                            onclick="deleteCartItem({{ $item->id_cart_item }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            @empty
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <h5>Your cart is empty</h5>
                    <p>Add some delicious cakes to get started!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Products</a>
                </div>
            @endforelse
        </div>

        @if(count($items) > 0)
            <div style="height: 120px;"></div>
            
            <div class="checkout-section">
                <div class="subtotal-row">
                    <span class="subtotal-label">Subtotal (<span id="selectedCount">0</span> items)</span>
                    <span class="subtotal-amount" id="subtotalAmount">Rp 0</span>
                </div>
                <button type="submit" class="purchase-btn" id="purchaseBtn" disabled>
                    Purchase
                </button>
            </div>
        @endif
    </form>

    {{-- Hidden forms for quantity updates --}}
    @foreach($items as $item)
        <form id="qtyForm{{ $item->id_cart_item }}" 
              action="{{ route('cart.update', $item->id_cart_item) }}" 
              method="POST" 
              style="display: none;">
            @csrf
            <input type="hidden" name="action" id="qtyAction{{ $item->id_cart_item }}">
        </form>
    @endforeach

    {{-- Hidden delete forms outside the main form --}}
    @foreach($items as $item)
        <form id="deleteForm{{ $item->id_cart_item }}" 
              action="{{ route('cart.delete', $item->id_cart_item) }}" 
              method="POST" 
              style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>

<script>
function updateQuantity(itemId, action) {
    document.getElementById('qtyAction' + itemId).value = action;
    document.getElementById('qtyForm' + itemId).submit();
}

function deleteCartItem(itemId) {
    if (confirm('Remove this item from cart?')) {
        document.getElementById('deleteForm' + itemId).submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const selectedCountEl = document.getElementById('selectedCount');
    const subtotalAmountEl = document.getElementById('subtotalAmount');
    const purchaseBtn = document.getElementById('purchaseBtn');

    function updateCheckout() {
        let selectedCount = 0;
        let subtotal = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                subtotal += price * quantity;
            }
        });

        selectedCountEl.textContent = selectedCount;
        subtotalAmountEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

        if (selectedCount > 0) {
            purchaseBtn.disabled = false;
        } else {
            purchaseBtn.disabled = true;
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCheckout);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
