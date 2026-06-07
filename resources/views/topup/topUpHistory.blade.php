<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Top Up History</title>
</head>
<body>
<div>
    @foreach ($topUps as $topUp)
        <div>
            <span>{{ $topUp->amount }}</span>
            <span>{{ $topUp->date }} {{ $topUp->time }}</span>
        </div>
    @endforeach

    {{ $topUps->links() }}
</div>
</body>
</html>