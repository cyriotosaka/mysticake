<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Top Up - Indomaret Payment - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUpCoinIndomaret3.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <a href="{{ route('topup.indomaret.page') }}" class="back-button">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Coin Top Up</span>
    </div>

    <!-- Fixed Floating Bar with Payment Info -->
    <div class="floating-bar-extended">
        <div class="payment-info-row">
            <span class="info-label">Total Payment</span>
            <span class="info-value">Rp{{ number_format($totalPayment ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="divider-line"></div>
        <div class="payment-info-row">
            <span class="info-label">Payment Within</span>
            <div class="countdown-container">
                <span class="countdown-text" id="countdownText">23 hours 59 minutes</span>
                <span class="due-date" id="dueDate">Due on {{ $dueDate ?? '' }}, {{ $dueTime ?? '' }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Indomaret Payment Card -->
        <div class="payment-card">
            <div class="store-header">
                <img src="{{ asset('images/topup/indomaret.png') }}" alt="Indomaret" class="store-logo">
                <span class="store-name">Indomaret</span>
            </div>
            
            <div class="divider-line-dark"></div>
            
            <div class="barcode-section">
                <span class="barcode-label">Payment Barcode</span>
                <div class="barcode-container">
                    <img src="{{ asset('images/topup/barcode.png') }}" alt="Barcode" class="barcode-image">
                </div>
            </div>
        </div>

        <!-- Info Text -->
        <div class="info-container">
            <i class="bi bi-info-circle info-icon"></i>
            <span class="info-text">Inform the Indomaret cashier that you're making payment coin top up MYstiCake and show the barcode payment and make your payment.</span>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Countdown Timer
        const expiresAt = new Date('{{ $expiresAt ?? '' }}').getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = expiresAt - now;
            
            if (distance < 0) {
                document.getElementById('countdownText').textContent = 'Expired';
                document.getElementById('dueDate').textContent = 'Payment expired';
                return;
            }
            
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            document.getElementById('countdownText').textContent = hours + ' hours ' + minutes + ' minutes';
        }
        
        // Update countdown every minute
        updateCountdown();
        setInterval(updateCountdown, 60000);
    </script>
</body>
</html>
