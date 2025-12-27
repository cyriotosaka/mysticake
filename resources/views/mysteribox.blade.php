<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MYstiCake') }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @include('partials.theme-script')
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="mysticake-body">
        <div class="mysticake-container">
            <!-- Header -->
            <header class="mysterybox-header">
                <button class="back-button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <h1 class="mysticake-logo">MYstiCake</h1>
                
                <button class="info-button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                </button>
            </header>

            <!-- User Info -->
            <div class="user-info">
                <button class="profile-button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </button>
                
                <div class="coin-display">
                    <span class="coin-icon">🪙</span>
                    <span class="coin-amount">120.000</span>
                    <button class="coin-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <main class="mysterybox-content">
                <h2 class="mysterybox-title">Normal<br>Mystery Box</h2>
                
                <button class="gacha-history-button">Gacha History</button>

                <!-- Mystery Box -->
                <div class="mysterybox-display">
                    <button class="zoom-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>
                    
                    <img src="{{ asset('images/mystery-box-closed.png') }}" alt="Mystery Box" class="mysterybox-image">
                    
                    <div class="gift-counter-small">
                        <img src="{{ asset('images/gift-icon.png') }}" alt="Gift" class="gift-icon-small">
                        <span class="gift-count-small">0/100</span>
                    </div>
                    
                    <button class="undo-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z"/>
                        </svg>
                    </button>
                </div>

                <!-- Purchase Button -->
                <button class="purchase-button">
                    <span class="purchase-price">15.000</span>
                    <span class="coin-icon-button">🪙</span>
                </button>
            </main>
        </div>
    </body>
</html>