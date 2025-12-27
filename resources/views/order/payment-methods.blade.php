{{--
    Nama: Abdul Ghoni
    NRP: 5026231109
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods - MystiCake</title>
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

        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .payment-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #E66A7F;
        }

        .payment-icon {
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

        .payment-name {
            font-size: 16px;
            font-weight: 600;
            color: #2D2D2D;
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
        <div class="page-header mb-0">Payment Methods</div>
    </div>

    @foreach($paymentMethods as $method)
        <form action="{{ route('order.payment.method.select', $method->id_payment_method) }}" method="POST" style="margin: 0;">
            @csrf
            <div class="payment-card" onclick="this.closest('form').submit()">
                <div class="d-flex align-items-center gap-3">
                    <div class="payment-icon">
                        @php
                            $methodName = strtolower($method->name_method);
                        @endphp
                        
                        @if(str_contains($methodName, 'debit'))
                            <i class="bi bi-credit-card"></i>
                        @elseif(str_contains($methodName, 'bank'))
                            <i class="bi bi-bank"></i>
                        @elseif(str_contains($methodName, 'wallet'))
                            <i class="bi bi-wallet2"></i>
                        @elseif(str_contains($methodName, 'cash'))
                            <i class="bi bi-cash-stack"></i>
                        @elseif(str_contains($methodName, 'indomaret') || str_contains($methodName, 'alfamart'))
                            <i class="bi bi-shop"></i>
                        @else
                            <i class="bi bi-credit-card"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="payment-name">{{ $method->name_method }}</div>
                    </div>
                    <i class="bi bi-chevron-right" style="color: #CCC;"></i>
                </div>
            </div>
        </form>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
