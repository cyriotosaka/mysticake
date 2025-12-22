<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gacha History</title>

    <link rel="stylesheet" href="{{ asset('css/gacha.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="theme-{{ $mode }}">

<div class="history-wrapper">

    <!-- HEADER -->
    <div class="history-header">
        <h1>Gacha History</h1>
        <a href="{{ route('gacha.index', ['mode' => $mode]) }}" class="close-btn">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <!-- INFO -->
    <div class="history-info">
        Gacha history shows up to 10 latest draws
    </div>

    <!-- LIST -->
    <div class="history-list">
        @forelse($histories as $history)
            <div class="history-item">
                <img
                    src="{{ asset('images/' . $history->product->product_picture) }}"
                    class="item-img"
                    alt="{{ $history->product->name_product }}"
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
                No gacha history yet ✨
            </div>
        @endforelse
    </div>

</div>

</body>
</html>
