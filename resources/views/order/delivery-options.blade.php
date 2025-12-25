{{--
    Nama: Abdul Ghoni
    NRP: 5026231109
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Options - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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

        .delivery-card {
            background: white;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .delivery-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #E66A7F;
        }

        .delivery-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #FFE5EC 0%, #FFD0DA 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #E66A7F;
        }

        .delivery-name {
            font-size: 16px;
            font-weight: 600;
            color: #2D2D2D;
            margin-bottom: 4px;
        }

        .delivery-price {
            font-size: 15px;
            font-weight: 600;
            color: #E66A7F;
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
        <a href="{{ route('order.payment') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        <div class="page-header mb-0">Delivery Options</div>
    </div>

    @foreach($deliveries as $delivery)
        <form action="{{ route('order.delivery.select', $delivery->id_delivery) }}" method="POST" style="margin: 0;">
            @csrf
            <div class="delivery-card" onclick="this.closest('form').submit()">
                <div class="d-flex align-items-center gap-3">
                    <div class="delivery-icon">
                        @php
                            $type = strtolower($delivery->type);
                        @endphp
                        
                        @if($type == 'motor')
                            <i class="bi bi-scooter"></i>
                        @elseif($type == 'mobil')
                            <i class="bi bi-truck"></i>
                        @elseif($type == 'express motor')
                            <i class="bi bi-lightning-charge-fill"></i>
                        @elseif($type == 'express mobil')
                            <i class="bi bi-lightning-charge-fill"></i>
                        @elseif($type == 'express')
                            <i class="bi bi-lightning-fill"></i>
                        @else
                            <i class="bi bi-truck"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="delivery-name">{{ $delivery->type }}</div>
                        <div class="delivery-price">Rp {{ number_format($delivery->delivery_charges, 0, ',', '.') }}</div>
                    </div>
                    <i class="bi bi-chevron-right" style="color: #CCC;"></i>
                </div>
            </div>
        </form>
    @endforeach

    @if(count($deliveries) == 0)
        <div class="text-center text-muted mt-5">
            <i class="bi bi-inbox" style="font-size: 48px;"></i>
            <p class="mt-3">No delivery options available</p>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
