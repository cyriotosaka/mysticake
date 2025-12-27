<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gacha Reveal</title>

    <link href="{{ asset('css/gacha.css') }}" rel="stylesheet">
</head>

<body class="{{ $mode == 'premium' ? 'theme-premium' : 'theme-normal' }}">

    <div class="top-header">
        <a href="{{ route('home') }}" class="icon-btn"><i class="fas fa-arrow-left"></i></a>
        <img src="{{ asset('images/mysticake_pink.png') }}" alt="MYstiCake" class="brand-logo-img">
        <div class="icon-btn" onclick="openModal('pageInfoModal')"><i class="fas fa-info-circle"></i></div>
    </div>

    <div id="stage-closed" class="box-stage">

        <div class="result-title">
            <img src="{{ $mode == 'premium' ? asset('images/judul_premium.png') : asset('images/judul_normal.png') }}"
                id="dynamicTitleImg"
                class="gacha-title-img"
                alt="Mode Title">
        </div>

        <div>
            <img src="{{ $mode == 'premium' ? asset('images/mystery_box.png') : asset('images/mystery_box.png') }}"
                 alt="Mystery Box"
                 class="mystery-box-large"
                 id="clickable-box"
                 onclick="openBox()">
        </div>

        <div class="tap-hint">Tap the Mystery Box !</div>
    </div>


    <div id="stage-opened" class="box-stage">

        <div class="congrats-text">CONGRATULATIONS!</div>

        <img src="{{ asset('images/products/' . $result->product_picture) }}" alt="Prize" class="product-reveal-img">

        <div class="product-name">{{ $result->name_product }}</div>

        <img src="{{ asset('images/box_open.png') }}" alt="Box Open" class="box-open-img">

        <a href="{{ url('/gacha') }}" class="btn-next">Next</a>

    </div>

    <script>
        function openBox() {
            const box = document.getElementById('clickable-box');
            const stageClosed = document.getElementById('stage-closed');
            const stageOpened = document.getElementById('stage-opened');

            // 1. Mulai animasi getar
            box.classList.add('shaking');

            // 2. Tunggu animasi selesai (800ms)
            setTimeout(() => {
                // Hilangkan stage 1 pelan-pelan
                stageClosed.style.opacity = '0';

                setTimeout(() => {
                    stageClosed.style.display = 'none';
                    stageOpened.style.display = 'flex'; // Munculkan stage 2

                    // Fade in stage 2
                    stageOpened.style.opacity = '0';
                    setTimeout(() => {
                        stageOpened.style.opacity = '1';
                    }, 50);

                }, 500);
            }, 800);
        }
    </script>
</body>
</html>
