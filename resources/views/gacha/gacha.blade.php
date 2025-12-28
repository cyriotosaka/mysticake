<!DOCTYPE html>
<html lang="id">
<!-- Created by Arsya Nueva_099 -->
<!-- Updated by Okky Priscila_168 - Menambahkan link droprate berdasarkan mode gacha -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystery Box - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/gacha.css') }}">
    <style>
        /* Tambahan animasi untuk tombol bonus jika penuh */
        .shaking-btn { animation: shake 1.5s infinite; filter: drop-shadow(0 0 5px gold); }
        @keyframes shake { 0% { transform: rotate(0deg); } 25% { transform: rotate(5deg); } 75% { transform: rotate(-5deg); } 100% { transform: rotate(0deg); } }
    </style>
</head>

<body class="theme-{{ $mode }}" id="bodyTheme">

<div class="mobile-container">

    <div class="top-header">
        <a href="{{ route('home') }}" class="icon-btn"><i class="fas fa-arrow-left"></i></a>
        <img src="{{ asset('images/mysticake_pink.png') }}" alt="MYstiCake" class="brand-logo-img">
        <div class="icon-btn" onclick="openModal('pageInfoModal')"><i class="fas fa-info-circle"></i></div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger text-center m-3" style="font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="user-stats-row">
        <div class="profile-circle">
            @if(Auth::user()->profile_pic)
                <img src="{{ asset(Auth::user()->profile_pic) }}" alt="User">
            @else
                <i class="fas fa-user-circle" style="font-size: 40px; color: #F06292;"></i>
            @endif
        </div>

        <div class="coin-pill">
            <i class="fas fa-coins text-warning coin-icon"></i>
            <span id="userBalance">{{ number_format($user->wallet->saldo_coin ?? 0, 0, ',', '.') }}</span>

            <a href="{{ route('topup.coin') }}" style="color: inherit; text-decoration: none;">
                <i class="fas fa-plus-circle plus-btn"></i>
            </a>
        </div>
    </div>

    <div class="title-container text-center">
        <img src="{{ $mode == 'premium' ? asset('images/judul_premium.png') : asset('images/judul_normal.png') }}"
            id="dynamicTitleImg" class="gacha-title-img" alt="Mode Title">
    </div>

    <div class="gacha-container">

        <a href="{{ route('gacha.history', ['mode' => $mode]) }}" class="history-pill">Gacha History</a>
        
        @php
            // Tentukan route berdasarkan mode saat ini
            $dropRateRoute = ($mode == 'premium') ? route('gacha.droprate.premium') : route('gacha.droprate.normal');
        @endphp
        
        <a href="{{ $dropRateRoute }}" class="float-btn drop-rate-btn">
            <i class="fas fa-chart-pie drop-rate-icon"></i>
        </a>

        @php
            $userPoint = $user->wallet->point_gacha ?? 0;
            $isFull = $userPoint >= 100;
        @endphp

        <div class="float-btn bonus-box-btn {{ $isFull ? 'shaking-btn' : '' }}"
             onclick="{{ $isFull ? 'confirmBonus()' : "openModal('bonusInfoModal')" }}"
             style="cursor: pointer;">
            <img src="{{ asset('images/point.png') }}" class="bonus-icon" alt="Bonus">
            <div class="bonus-count" style="{{ $isFull ? 'color: #D81B60; font-weight:900;' : '' }}">
                {{ $userPoint }}/100
            </div>
        </div>

        <div class="float-btn btn-undo" onclick="toggleMode()"><i class="fas fa-reply"></i></div>

        <img src="{{ asset('images/mystery.png') }}" id="mysteryBoxImg" class="mystery-box-main" alt="Mystery Box" onclick="confirmPurchase()">

        <button class="play-btn" onclick="confirmPurchase()">
            <span id="priceText">{{ $mode == 'premium' ? '25.000' : '15.000' }}</span>
            <i class="fas fa-coins"></i>
        </button>

    </div>

    <form id="gachaForm" action="{{ route('gacha.roll') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="type" id="inputType" value="{{ $mode }}">
    </form>


    <div id="pageInfoModal" class="modal-overlay" onclick="closeModal(event, 'pageInfoModal')">
        <div class="info-card">
            <div class="info-title">Page Info:</div>
            <div class="info-desc" id="infoContent">
                @if($mode == 'premium')
                    Premium Mystery Box: Higher chance! Price 25k - 100k.
                @else
                    This is Normal Mystery Box page, where you can get random desserts with more or less expensive prices depending on your luck (around 10k to 30k).
                @endif
            </div>
        </div>
    </div>

    <div id="bonusInfoModal" class="modal-overlay" onclick="closeModal(event, 'bonusInfoModal')">
        <div class="info-card">
            <div class="info-title">Bonus box</div>
            <div class="info-desc">
                Collect up to 100 points to get a free draw chance. Every draw gives 10 points.
            </div>
        </div>
    </div>

    <script>
        let currentMode = "{{ $mode ?? 'normal' }}";
        let userBalance = parseInt("{{ $user->wallet->saldo_coin ?? 0 }}");
        let userPoint = parseInt("{{ $userPoint }}");

        function toggleMode() {
            const nextMode = currentMode === 'normal' ? 'premium' : 'normal';
            window.location.href = `/gacha?mode=${nextMode}`;
        }

        function confirmPurchase() {
            let cost = (currentMode === 'premium') ? 25000 : 15000;
            let formattedCost = (currentMode === 'premium') ? '25.000' : '15.000';

            if (userBalance < cost) {
                alert("Koin kamu tidak cukup! Silakan Top Up.");
                return;
            }

            let isConfirmed = confirm(`Yakin ingin membeli ${currentMode} Box seharga ${formattedCost} koin?`);
            if (isConfirmed) {
                document.getElementById('inputType').value = currentMode;
                document.getElementById('gachaForm').submit();
            }
        }

        function confirmBonus() {
            if (userPoint < 100) return;
            let isConfirmed = confirm("Selamat! Poin kamu sudah 100.\nIngin tukar dengan 1x GRATIS Mystery Box?");
            if (isConfirmed) {
                // Set input jadi 'bonus' lalu submit
                document.getElementById('inputType').value = 'bonus';
                document.getElementById('gachaForm').submit();
            }
        }

        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(event, id) {
            if (event.target.classList.contains('modal-overlay')) {
                document.getElementById(id).style.display = 'none';
            }
        }
    </script>
</div>
</body>
</html>