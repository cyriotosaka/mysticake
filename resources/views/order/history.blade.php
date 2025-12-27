<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')
    <style>
        body {
            background: #FFF5F7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .page-header {
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0;
            color: #2D2D2D;
        }

        .order-card {
            background: white;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            text-decoration: none;
            display: block;
            transition: all 0.2s;
        }

        .order-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .order-id {
            font-size: 16px;
            font-weight: 600;
            color: #2D2D2D;
        }

        .order-status {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending {
            background: #FFF3CD;
            color: #856404;
        }

        .status-completed {
            background: #D1F2DD;
            color: #1E7E34;
        }

        .status-cancelled {
            background: #F8D7DA;
            color: #721C24;
        }

        .order-date {
            font-size: 13px;
            color: #757575;
            margin-bottom: 8px;
        }

        .order-items {
            font-size: 14px;
            color: #2D2D2D;
            margin-bottom: 10px;
        }

        .order-total {
            font-size: 16px;
            font-weight: 700;
            color: #E66A7F;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            color: #DDD;
            margin-bottom: 15px;
        }

        .back-btn {
            color: #2D2D2D;
            font-size: 24px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('home') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        <div class="page-header mb-0">Order History</div>
    </div>

    @forelse($orders as $order)
        <a href="{{ route('order.details', $order->id_order) }}" class="order-card">
            <div class="order-header">
                <div class="order-id">Order #{{ str_pad($order->id_order, 6, '0', STR_PAD_LEFT) }}</div>
                <span class="order-status status-{{ strtolower($order->status_order) }}">
                    {{ ucfirst($order->status_order) }}
                </span>
            </div>
            
            <div class="order-date">
                <i class="bi bi-calendar3"></i> {{ $order->getFormattedDate() }}
            </div>

            <div class="order-items">
                <i class="bi bi-box-seam"></i> {{ $order->totalItems() }} items
            </div>

            <div class="order-total">
                {{ $order->getFormattedTotal() }}
            </div>
        </a>
    @empty
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            <h5>No Orders Yet</h5>
            <p>Start your sweet journey by placing an order!</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Products</a>
        </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
