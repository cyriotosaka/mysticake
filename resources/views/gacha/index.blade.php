<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystery Box - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/gacha.css') }}">
</head>
<body class="theme-normal" id="bodyTheme">

    <div class="gacha-header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>

            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
                <div class="coin-display">
                    <i class="fas fa-coins coin-icon"></i>
                    <span id="userBalance">{{ number_format($user->balance ?? 120000, 0, ',', '.') }}</span>
                    <i class="fas fa-plus-circle ms-2 small"></i>
                </div>
            </div>
        </div>

        <i class="fas fa-info-circle info-btn" onclick="openModal('pageInfoModal')"></i>
    </div>

    <div class="text-center mt-2">
        <div class="brand-text">MYstiCake</div>
    </div>

    <div class="wavy-tabs-container">
        <svg class="wave-svg" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
            <path id="wavePath" fill="none" stroke="#4E342E" stroke-width="3"
                  d="M0,60 C320,120 420,0 720,60 C1020,120 1120,0 1440,60"></path>
        </svg>

        <div class="mode-switcher">
            <div class="mode-text normal active" onclick="switchMode('normal')">Normal</div>
            <div class="mode-text premium" onclick="switchMode('premium')">Premium</div>
        </div>
    </div>

    <div class="sub-title" id="boxTitle">MYstery BoX</div>

    <div class="gacha-container">

        <a href="{{ route('gacha.droprates') }}" class="float-btn drop-rate-btn">
            <i class="fas fa-chart-pie drop-rate-icon"></i>
        </a>

        <div class="float-btn bonus-box-btn" onclick="openModal('bonusInfoModal')">
            <img src="{{ asset('images/mystery_box.png') }}" class="bonus-icon" alt="Bonus">
            <div class="bonus-count">0/100</div>
        </div>

        <a href="{{ route('gacha.history') }}" class="history-pill">
            Gacha History
        </a>

        <img src="{{ asset('images/mystery_box.png') }}"
             id="mysteryBoxImg"
             class="mystery-box-main"
             alt="Mystery Box"
             onclick="playGacha()">

        <div class="mt-4 text-center text-muted small" id="tapHint">Tap the Mystery Box !</div>

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
        let currentMode = 'normal';
        const boxImg = document.getElementById('mysteryBoxImg');
        const body = document.getElementById('bodyTheme');

        // Data Dummy untuk UI Switching
        const dataUI = {
            normal: {
                price: '15.000',
                img: "{{ asset('images/mystery_box.png') }}", // Pastikan file ini ada
                info: "This is Normal Mystery Box page, price around 10k to 30k.",
                color: '#4E342E'
            },
            premium: {
                price: '25.000',
                img: "{{ asset('images/mystery_box.png') }}", // Pastikan file ini ada
                info: "This is Premium Mystery Box page! Higher chance for rare items. Price around 25k to 100k.",
                color: '#D81B60'
            }
        };

        // Fungsi Ganti Mode (Slide Effect)
        function switchMode(mode) {
            currentMode = mode;

            // 1. Update Class Active Text
            document.querySelectorAll('.mode-text').forEach(el => el.classList.remove('active'));
            document.querySelector(`.mode-text.${mode}`).classList.add('active');

            // 2. Ganti Tema Body (Warna BG & Text)
            body.className = `theme-${mode}`;

            // 3. Ganti Gambar Box & Harga
            boxImg.src = dataUI[mode].img;
            document.getElementById('priceText').innerText = dataUI[mode].price;
            document.getElementById('infoContent').innerText = dataUI[mode].info;

            // 4. Update Warna SVG Wave (Optional)
            const wavePath = document.getElementById('wavePath');
            wavePath.setAttribute('stroke', dataUI[mode].color);
        }

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
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Token keamanan wajib Laravel
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
                    // Jika error (misal koin habis)
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
        function showResult() {
            // Di sini nanti inject data dari AJAX Response
            // Contoh Hardcode:
            const prizeImg = document.getElementById('prizeImage');
            const prizeName = document.getElementById('prizeName');

            if(data.item_image) {
                // Asumsi gambar ada di folder public/images/
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
    </script>
</body>
</html>
