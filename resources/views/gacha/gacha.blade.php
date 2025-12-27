<!DOCTYPE html>
<html lang="id">
<!-- Updated by Okky Priscila_168 - Menambahkan link droprate berdasarkan mode gacha -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystery Box - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/gacha.css') }}">
</head>
<body class="theme-{{ $mode }}">

<div class="mobile-container">

        <div class="top-header">
            <a href="{{ route('home') }}" class="icon-btn"><i class="fas fa-arrow-left"></i></a>
            <img src="{{ asset('images/mysticake_pink.png') }}" alt="MYstiCake" class="brand-logo-img">
            <div class="icon-btn" onclick="openModal('pageInfoModal')"><i class="fas fa-info-circle"></i></div>
        </div>

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
                <i class="fas fa-plus-circle plus-btn"></i>
            </div>
        </div>

    <div class="title-container text-center">
        <img src="{{ asset('images/judul_normal.png') }}"
            id="dynamicTitleImg"
            class="gacha-title-img"
            alt="Mode Title">
    </div>

    <div class="gacha-container">

        <a href="{{ route('gacha.history', ['mode' => $mode]) }}" class="history-pill">
            Gacha History
        </a>

        {{-- Link Drop Rate berdasarkan Mode - Updated by Okky Priscila_168 --}}
        @if($mode === 'premium')
            <a href="{{ route('gacha.droprate.premium') }}" class="float-btn drop-rate-btn">
                <i class="fas fa-chart-pie drop-rate-icon"></i>
            </a>
        @else
            <a href="{{ route('gacha.droprate.normal') }}" class="float-btn drop-rate-btn">
                <i class="fas fa-chart-pie drop-rate-icon"></i>
            </a>
        @endif

        <div class="float-btn bonus-box-btn" onclick="openModal('bonusInfoModal')">
            <img src="{{ asset('images/point.png') }}" class="bonus-icon" alt="Bonus">
            <div class="bonus-count">0/100</div>
        </div>

        <div class="float-btn btn-undo" onclick="toggleMode()">
            <i class="fas fa-reply"></i>
        </div>

        <img src="{{ asset('images/mystery_box.png') }}"
             id="mysteryBoxImg"
             class="mystery-box-main"
             alt="Mystery Box"
             onclick="playGacha()">

        <button class="play-btn" onclick="playGacha()">
            <span id="priceText">15.000</span> <i class="fas fa-coins"></i>
        </button>

    </div>

    <div id="pageInfoModal" class="modal-overlay" onclick="closeModal(event, 'pageInfoModal')">
        <div class="info-card">
            <div class="info-title">Page Info:</div>
            <div class="info-desc" id="infoContent">
                This is Normal Mystery Box page, where you can get random desserts with more or less expensive prices depending on your luck (around 10k to 30k).
            </div>
        </div>
    </div>

    <div id="bonusInfoModal" class="modal-overlay" onclick="closeModal(event, 'bonusInfoModal')">
        <div class="info-card">
            <div class="info-title">Bonus box</div>
            <div class="info-desc">
                Collect up to 100 points to get a free draw chance. Every normal draw gives 10 points.
            </div>
        </div>
    </div>

    <div id="congratsScreen" class="congrats-overlay">
        <div class="brand-text mb-4">MYstiCake</div>

        <div class="congrats-title">CONGRATULATIONS!</div>

        <img src="" id="prizeImage" class="prize-img" alt="Prize">
        <div class="prize-name" id="prizeName">Loading...</div>

        <img src="{{ asset('images/box_open.png') }}" class="open-box-img" alt="Open Box">

        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('images/mystery_box.png') }}" width="30">
            <span class="ms-2 fw-bold">+10</span>
        </div>

        <button class="next-btn" onclick="resetGacha()">Next</button>
    </div>


    <script>
        let currentMode = "{{ $mode ?? 'normal' }}";
        const boxImg = document.getElementById('mysteryBoxImg');
        const titleImg = document.getElementById('dynamicTitleImg');
        const body = document.body; // FIX: ganti dari getElementById ke document.body

        // DATABASE TAMPILAN (Setting Gambar & Warna di sini)
        const dataUI = {
            normal: {
                price: '15.000',
                box: "{{ asset('images/mystery_box.png') }}",
                title: "{{ asset('images/judul_normal.png') }}",
                info: "Normal Mystery Box: Price around 10k - 30k.",
                themeClass: 'theme-normal'
            },
            premium: {
                price: '25.000',
                box: "{{ asset('images/mystery_box.png') }}",
                title: "{{ asset('images/judul_premium.png') }}",
                info: "Premium Mystery Box: Higher chance! Price 25k - 100k.",
                themeClass: 'theme-premium'
            }
        };

        // Fungsi Toggle Mode (Dipanggil saat klik Tombol Undo)
        function toggleMode() {
            const nextMode = currentMode === 'normal' ? 'premium' : 'normal';
            window.location.href = `/gacha?mode=${nextMode}`;
        }

        function updateUI() {
            const ui = dataUI[currentMode];

            // HAPUS theme lama
            body.classList.remove('theme-normal', 'theme-premium');

            // TAMBAH theme baru
            body.classList.add(ui.themeClass);

            titleImg.src = ui.title;
            boxImg.src = ui.box;
            document.getElementById('priceText').innerText = ui.price;
            document.getElementById('infoContent').innerText = ui.info;
        }

        // Panggil updateUI saat halaman load
        updateUI();

        // Fungsi Play Gacha
        function playGacha() {
            let currentCoin = parseInt(document.getElementById('userBalance').innerText.replace(/\./g, ''));
            let cost = (currentMode === 'premium') ? 25000 : 15000;

            if (currentCoin < cost) {
                alert("Koin kamu tidak cukup! (Sisa: " + currentCoin + ")");
                return;
            }

            // 2. Animasi Shake
            boxImg.classList.add('shaking');

            // 3. Panggil Backend Laravel
            fetch("{{ route('gacha.roll') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    type: currentMode
                })
            })
            .then(response => response.json())
            .then(data => {
                // Stop Animasi
                boxImg.classList.remove('shaking');

                if (data.status === 'success') {
                    // Update Koin di Layar
                    document.getElementById('userBalance').innerText = new Intl.NumberFormat('id-ID').format(data.remaining_coin);

                    // Tampilkan Hasil
                    showResult(data);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                boxImg.classList.remove('shaking');
                console.error('Error:', error);
                alert("Terjadi kesalahan koneksi.");
            });
        }

        // Tampilkan Layar Congratulations
        function showResult(data) {
            const prizeImg = document.getElementById('prizeImage');
            const prizeName = document.getElementById('prizeName');

            if(data.item_image) {
                prizeImg.src = "/images/" + data.item_image;
            } else {
                prizeImg.src = "https://placehold.co/200?text=No+Image";
            }

            prizeName.innerText = data.item_name;

            document.getElementById('congratsScreen').style.display = 'flex';
        }

        function resetGacha() {
            document.getElementById('congratsScreen').style.display = 'none';
        }

        // Modal Logic
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(event, id) {
            if (event.target.classList.contains('modal-overlay')) {
                document.getElementById(id).style.display = 'none';
            }
        }

        function goToHistory() {
            window.location.href = "{{ route('gacha.history') }}?mode=" + currentMode;
        }

    </script>
</div>
</body>
</html>