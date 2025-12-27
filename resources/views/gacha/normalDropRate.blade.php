<!DOCTYPE html>
<html lang="id">
<!-- Created by Okky Priscila_168 -->
<!-- Updated - Drop rate sekarang dinamis berdasarkan stock produk -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normal Drop Rate - MYstiCake</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:700|reem-kufi:700" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/normalDropRate.css') }}">
</head>
<body>
    <div class="droprate-container">
        <!-- Fixed Header -->
        <header class="droprate-header">
            <h1 class="droprate-title">Drop Rate</h1>
            <button class="close-button" onclick="window.history.back()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </header>

        <!-- Scrollable List -->
        <main class="droprate-list">
            {{-- 
                Data $rewards sekarang berasal dari Controller (MysteryBoxController)
                Format: ['name' => 'Product Name', 'rate' => '15.50%', 'stock' => 40]
                Drop rate dihitung berdasarkan: (stock produk / total stock) * 100%
            --}}
            @forelse($rewards as $reward)
                <div class="droprate-item">
                    <span class="reward-name">{{ $reward['name'] }}</span>
                    <span class="reward-rate">{{ $reward['rate'] }}</span>
                </div>
            @empty
                <div class="droprate-item">
                    <span class="reward-name">No products available</span>
                    <span class="reward-rate">0.00%</span>
                </div>
            @endforelse
        </main>
    </div>
</body>
</html>