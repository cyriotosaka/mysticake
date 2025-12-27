<!---Updated by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($address) ? 'Edit Address' : 'Add Address' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    @include('partials.theme-script')
</head>
<body>
    <div class="container pt-3">
        <div class="header-nav">
            <a href="{{ route('address.index') }}"><i class="bi bi-arrow-left fs-4"></i></a>
            <div class="header-title">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</div>
        </div>

        <form action="{{ isset($address) ? route('address.update', $address->id_address) : route('address.store') }}" method="POST">
            @csrf
            @if(isset($address))
                @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Full Address</label>
                <textarea name="full_address" class="form-control-underlined" rows="3" placeholder="Ex: Jl. Keputih No. 10" required>{{ old('full_address', $address->full_address ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Contact Number</label>
                <input type="text" 
                       name="address_contact_number" 
                       class="form-control-underlined" 
                       value="{{ old('address_contact_number', $address->address_contact_number ?? '') }}" 
                       placeholder="0812..." 
                       required>
            </div>

            <button type="submit" class="btn btn-pink mt-4">Save Address</button>
        </form>
    </div>
</body>
</html>
