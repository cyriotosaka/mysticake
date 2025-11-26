<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
</head>
<body>
    <div class="container pt-3">
        <div class="header-nav">
            <a href="{{ route('settings.profile') }}"><i class="bi bi-arrow-left fs-4"></i></a>
            <div class="header-title">Change Address</div>
            <i class="bi bi-info-circle fs-5"></i>
        </div>

        <h3 class="text-center mb-4" style="font-weight: 700; color: #4E342E;">My Address</h3>

        @foreach($addresses as $addr)
        <div class="address-card">
            <div class="address-title">Rumah / Kantor</div> <div class="address-details">
                {{ $addr->full_address }}<br>
                {{ $addr->address_contact }}
            </div>
            <a href="{{ route('address.edit', $addr->id_address) }}">
                <i class="bi bi-pencil-square address-edit-icon"></i>
            </a>
        </div>
        @endforeach

        <a href="{{ route('address.create') }}" class="btn btn-pink-light mt-3 d-block text-center">+ Add Address</a>
    </div>
</body>
</html>
