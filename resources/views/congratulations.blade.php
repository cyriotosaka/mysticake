<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MYstiCake') }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="mysticake-body">
        <div class="mysticake-container">
            <!-- Header -->
            <header class="mysticake-header">
                <h1 class="mysticake-logo">MYstiCake</h1>
            </header>

            <!-- Main Content -->
            <main class="congratulations-content">
                <h2 class="congratulations-title">CONGRATULATIONS!</h2>

                <!-- Donut Image -->
                <div class="reward-container">
                    <img src="{{ asset('images/donut.png') }}" alt="Caramel Donut" class="reward-image">
                    <p class="reward-name">Caramel Donut</p>
                </div>

                <!-- Gift Box -->
                <div class="gift-box-container">
                    <img src="{{ asset('images/gift-box.png') }}" alt="Gift Box" class="gift-box-image">
                </div>

                <!-- Bottom Section -->
                <div class="bottom-section">
                    <div class="gift-counter">
                        <img src="{{ asset('images/gift-icon.png') }}" alt="Gift" class="gift-icon">
                        <span class="gift-count">10/100</span>
                        <span class="gift-increment">+10</span>
                    </div>
                    
                    <button class="next-button">Next</button>
                </div>
            </main>
        </div>
    </body>
</html>