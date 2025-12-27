<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Success - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/topup/topUpSuccess.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header-container">
        <span class="header-title">Top-up Coin MystiCake</span>
    </div>

    <!-- Fixed Floating Bar -->
    <div class="floating-bar">
        <span class="floating-bar-text">Top Up Successful</span>
        <i class="bi bi-coin coin-icon"></i>
    </div>

    <!-- Main Content -->
    <div class="content-container">

        <!-- Success Card -->
        <div class="success-card">
            <div class="success-icon-container">
                <i class="bi bi-check-circle-fill success-icon"></i>
            </div>
            
            <h2 class="success-title">Top Up Successful!</h2>
            <p class="success-message">Your coins have been added to your wallet.</p>
            
            @if(session('message'))
                <p class="success-detail">{{ session('message') }}</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('home') }}" class="btn-primary-action">
                <i class="bi bi-house-fill"></i>
                <span>Back to Home</span>
            </a>
            
            <a href="{{ route('topup.index') }}" class="btn-secondary-action">
                <i class="bi bi-plus-circle"></i>
                <span>Top Up Again</span>
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>