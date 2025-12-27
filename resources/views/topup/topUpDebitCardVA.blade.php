<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUpDebitCardVA.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <a href="{{ route('topup.debitcard.add') }}" class="back-button">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="header-title">Payment</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <span class="admin-fee-label">Admin Fee</span>
        <span class="admin-fee-value">Rp{{ number_format($adminFee ?? 2000, 0, ',', '.') }}</span>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Virtual Account Card -->
        <div class="va-card">
            <div class="va-header">
                <img src="{{ asset('images/topup/debitCardDark.png') }}" alt="Debit Card" class="card-ic">
                <span class="va-title">Virtual Account</span>
            </div>
            
            <div class="va-body">
                <div class="va-label">Account Number</div>
                <div class="va-number-container">
                    <span class="va-number" id="vaNumber">{{ $virtualAccount }}</span>
                    <button class="copy-btn" onclick="copyToClipboard()">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
                
                <div class="va-divider"></div>
                
                <div class="va-info-text info-warning">
                    <span>It will take less than 10 minutes to verify after making payment</span>
                </div>
                
                <div class="va-info-text info-note">
                    To ensure Virtual Account number remains the same, please complete payment before creating another order with Virtual Account.
                </div>
                
                <div class="va-info-text info-bank">
                    Accepts transfers from [Bank Name] only.
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <i class="bi bi-info-circle info-icon"></i>
            <span class="info-text">Min. Top up amount is Rp10.000</span>
        </div>

    </div>

    <!-- OK Button -->
    <form action="{{ route('topup.debitcard.confirm') }}" method="POST">
        @csrf
        <button type="submit" class="ok-btn">
            <span>OK</span>
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyToClipboard() {
            const vaNumber = document.getElementById('vaNumber').innerText;
            const cleanNumber = vaNumber.replace(/\s/g, '');
            navigator.clipboard.writeText(cleanNumber).then(function() {
                alert('Virtual Account number copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</body>
</html>
