<!-- Created by Arsya Nueva_099 -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gacha History</title>

    <link rel="stylesheet" href="{{ asset('css/gacha.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @include('partials.theme-script')
</head>

<body class="theme-{{ $mode }}">

<div class="history-wrapper">

    <div class="history-header">
        <h1>Gacha History</h1>
        <a href="{{ url('/gacha') }}?mode={{ $mode }}" class="close-btn">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <div class="history-info">
        History shows your completed orders
    </div>

    <div class="history-list">
        @forelse($histories as $history)
            <div class="history-item">
                <img
                    src="{{ asset('images/products/' . $history->product->product_picture) }}"
                    class="item-img"
                    alt="{{ $history->product->name_product }}"
                    onerror="this.src='https://placehold.co/50'"
                >

                <div class="item-name">
                    {{ $history->product->name_product }}
                </div>

                <div class="item-time">
                    <i class="far fa-clock"></i>
                    {{ $history->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 10px; opacity: 0.5;"></i><br>
                Belum ada riwayat gacha.
            </div>
        @endforelse
    </div>

</div>

</body>
</html>
