<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #FFE5EC 0%, #FFF5F7 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .confirmation-container {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #E66A7F 0%, #D95570 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(230, 106, 127, 0.3);
            animation: scaleIn 0.5s ease-out;
        }

        .success-icon i {
            font-size: 60px;
            color: white;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .confirmation-title {
            font-size: 28px;
            font-weight: 700;
            color: #2D2D2D;
            margin-bottom: 12px;
        }

        .confirmation-subtitle {
            font-size: 16px;
            color: #757575;
            margin-bottom: 30px;
        }

        .order-info-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            max-width: 400px;
            margin: 0 auto 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #F0F0F0;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #F0F0F0;
        }

        .info-label {
            color: #757575;
            font-size: 14px;
        }

        .info-value {
            color: #2D2D2D;
            font-weight: 600;
            font-size: 14px;
            text-align: right;
        }

        .total-value {
            color: #E66A7F;
            font-weight: 700;
            font-size: 18px;
        }

        .tap-hint {
            font-size: 14px;
            color: #999;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
        }
    </style>
</head>
<body onclick="window.location.href='{{ route('home') }}'">

<div class="confirmation-container">
    <div class="success-icon">
        <i class="bi bi-check2"></i>
    </div>

    <h1 class="confirmation-title">Order Confirmed!</h1>
    <p class="confirmation-subtitle">Your order has been successfully placed</p>

    <div class="order-info-card">
        <div class="info-row">
            <span class="info-label">Order ID</span>
            <span class="info-value">#{{ str_pad($order->id_order, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Date</span>
            <span class="info-value">{{ $order->getFormattedDate() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Items</span>
            <span class="info-value">{{ $order->totalItems() }} items</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ $order->paymentMethod->name_method }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Payment</span>
            <span class="total-value">{{ $order->getFormattedTotal() }}</span>
        </div>
    </div>

    <p class="tap-hint">
        <i class="bi bi-hand-index"></i> Tap anywhere to return to home
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
