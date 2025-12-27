<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')
    <style>
        body {
            background: #FFF5F7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding-bottom: 30px;
        }

        .page-header {
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0;
            color: #2D2D2D;
        }

        .section-card {
            background: white;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #2D2D2D;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #F0F0F0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #FFF3CD;
            color: #856404;
        }

        .status-completed {
            background: #D1F2DD;
            color: #1E7E34;
        }

        .item-row {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #F5F5F5;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
        }

        .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #2D2D2D;
            margin-bottom: 4px;
        }

        .item-details {
            font-size: 13px;
            color: #757575;
        }

        .item-price {
            font-size: 14px;
            font-weight: 600;
            color: #E66A7F;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .info-label {
            color: #757575;
        }

        .info-value {
            color: #2D2D2D;
            font-weight: 600;
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0 10px;
            border-top: 2px solid #F0F0F0;
            margin-top: 10px;
        }

        .total-label {
            font-size: 16px;
            font-weight: 600;
            color: #2D2D2D;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #E66A7F;
        }

        .back-btn {
            color: #2D2D2D;
            font-size: 24px;
            text-decoration: none;
        }

        .timeline-item {
            padding: 10px 0;
            border-left: 2px solid #E66A7F;
            padding-left: 20px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            width: 10px;
            height: 10px;
            background: #E66A7F;
            border-radius: 50%;
            position: absolute;
            left: -6px;
            top: 15px;
        }

        .timeline-date {
            font-size: 13px;
            color: #2D2D2D;
            font-weight: 600;
        }

        .timeline-time {
            font-size: 12px;
            color: #757575;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('order.history') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        <div class="page-header mb-0">Order Details</div>
    </div>

    <!-- Order Info -->
    <div class="section-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 style="font-weight: 700; margin-bottom: 5px;">Order #{{ str_pad($order->id_order, 6, '0', STR_PAD_LEFT) }}</h5>
                <div style="font-size: 14px; color: #757575;">{{ $order->getFormattedDate() }}</div>
            </div>
            <span class="status-badge status-{{ strtolower($order->status_order) }}">
                {{ ucfirst($order->status_order) }}
            </span>
        </div>
    </div>

    <!-- Order Items -->
    <div class="section-card">
        <div class="section-title">Order Items ({{ $order->totalItems() }})</div>
        @foreach($order->items as $item)
            <div class="item-row">
                <img src="{{ asset('images/products/'.$item->product->product_picture) }}"
                     class="item-img"
                     onerror="this.src='https://placehold.co/60x60/FFE5EC/E66A7F?text=Cake';">
                <div class="flex-grow-1">
                    <div class="item-name">{{ $item->product->name_product }}</div>
                    <div class="item-details">Qty: {{ $item->quantity }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                </div>
                <div class="item-price">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Delivery Information -->
    <div class="section-card">
        <div class="section-title">Delivery Information</div>
        <div class="info-row">
            <span class="info-label"><i class="bi bi-geo-alt"></i> Address</span>
        </div>
        <div style="padding: 10px 0; color: #2D2D2D;">
            {{ $order->address->full_address }}
        </div>
        @if($order->address->address_contact_number)
            <div class="info-row">
                <span class="info-label"><i class="bi bi-telephone"></i> Contact</span>
                <span class="info-value">{{ $order->address->address_contact_number }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label"><i class="bi bi-truck"></i> Delivery Method</span>
            <span class="info-value">{{ $order->delivery->type }}</span>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="section-card">
        <div class="section-title">Payment Information</div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ $order->paymentMethod->name_method }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Subtotal</span>
            <span class="info-value">Rp {{ number_format($order->total_payment - $order->delivery->delivery_charges - ($order->extra_charges ?? 0), 0, ',', '.') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Delivery Charge</span>
            <span class="info-value">Rp {{ number_format($order->delivery->delivery_charges, 0, ',', '.') }}</span>
        </div>
        @if($order->extra_charges > 0)
            <div class="info-row">
                <span class="info-label">Extra Charges</span>
                <span class="info-value">Rp {{ number_format($order->extra_charges, 0, ',', '.') }}</span>
            </div>
        @endif
        <div class="total-row">
            <span class="total-label">Total Payment</span>
            <span class="total-amount">{{ $order->getFormattedTotal() }}</span>
        </div>
    </div>

    <!-- Order Timeline -->
    @if($order->histories->count() > 0)
        <div class="section-card">
            <div class="section-title">Order Timeline</div>
            @foreach($order->histories as $history)
                <div class="timeline-item">
                    <div class="timeline-date">{{ \Carbon\Carbon::parse($history->date)->format('d M Y') }}</div>
                    <div class="timeline-time">{{ \Carbon\Carbon::parse($history->time)->format('H:i') }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
