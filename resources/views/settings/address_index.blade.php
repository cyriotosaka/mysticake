<!---Updated by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    @include('partials.theme-script')

    <style>
        body {
            background-color: #FFFDF5;
            font-family: 'Instrument Sans', sans-serif;
            color: #4A4A4A;
        }

        .header-nav {
            display: flex;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 10px;
        }

        .header-title {
            flex-grow: 1;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
            margin-right: 24px;
        }

        .address-card {
            background: #ff6b83 !important; /* Pakai !important biar menimpa settings.css */
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: relative;
            border: 1px solid #ff6b83;
            color: #fdfcfcff; 
        }

        .address-title {
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
            font-size: 1rem;
        }

        .address-details {
            color: #eff2f4ff;
            font-size: 14px;
            line-height: 1.6;
        }

        /* --- TOMBOL EDIT & HAPUS --- */
        .action-link {
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .edit-link {
            color: #eff2f4ff; /* Biru */
        }
        
        .delete-link {
            color: #eff2f4ff; /* Pink */
            background: none;
            border: none;
            padding: 0;
        }

        /* --- TOMBOL ADD ADDRESS --- */
        .btn-add-custom {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            background-color: #FFC1CC; /* Pink muda */
            color: #D6336C; /* Pink tua */
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            margin-top: 20px;
            transition: 0.2s;
        }
        .btn-add-custom:hover {
            background-color: #ffb3c1;
            color: #c2185b;
        }
    </style>
    </head>
<body>
    <div class="container pt-3">
        <div class="header-nav">
            <a href="{{ route('settings.profile') }}" class="text-dark text-decoration-none">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <div class="header-title">Change Address</div>
            <i class="bi bi-info-circle fs-5 text-secondary"></i>
        </div>

        <h3 class="text-center mb-4" style="font-weight: 700; color: #4E342E;">My Address</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach($addresses as $addr)
        <div class="address-card position-relative">
            <div class="address-title">Delivery Address</div> 
            <div class="address-details">
                {{ $addr->full_address }}<br>
                <i class="bi bi-telephone me-1"></i> {{ $addr->address_contact_number }}
            </div>
            
            <div class="d-flex justify-content-end align-items-center mt-3 gap-3 border-top pt-2">
                {{-- Tombol Edit --}}
                <a href="{{ route('address.edit', $addr->id_address) }}" class="action-link edit-link">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                {{-- Tombol Delete --}}
                <form action="{{ route('address.destroy', $addr->id_address) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-link delete-link">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach

        {{-- Sembunyikan tombol jika sudah max 3 alamat --}}
        @if(isset($canAddMore) && $canAddMore)
            <a href="{{ route('address.create') }}" class="btn-add-custom">+ Add Address</a>
        @else
            <div class="text-center mt-3 text-muted small">Maksimal 3 alamat tercapai.</div>
        @endif
        
        <div style="height: 50px;"></div>
    </div>
</body>
</html>