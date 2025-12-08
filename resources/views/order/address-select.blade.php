<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Address - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #FFF5F7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .page-header {
            font-size: 24px;
            font-weight: 700;
            color: #2D2D2D;
        }

        .address-count {
            font-size: 14px;
            color: #999;
            margin-left: 8px;
        }

        .address-card {
            background: white;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .address-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .address-card.selected {
            border: 2px solid #E66A7F;
            box-shadow: 0 4px 12px rgba(230, 106, 127, 0.2);
        }

        .delete-btn {
            position: absolute;
            top: 18px;
            right: 18px;
            background: none;
            border: none;
            color: #FF8A9B;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            color: #E66A7F;
            transform: scale(1.1);
        }

        .edit-link {
            display: inline-block;
            color: #4A90E2;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 12px;
            padding: 4px 0;
            transition: all 0.2s;
        }

        .edit-link:hover {
            color: #357ABD;
            text-decoration: underline;
        }

        .edit-link i {
            margin-right: 4px;
        }

        .add-address-btn {
            width: 100%;
            background: #fff;
            border: 2px dashed #E66A7F;
            color: #E66A7F;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .add-address-btn:hover:not(:disabled) {
            background: #FFF5F7;
        }

        .add-address-btn:disabled {
            border-color: #DDD;
            color: #999;
            cursor: not-allowed;
        }

        .back-btn {
            color: #2D2D2D;
            font-size: 24px;
            text-decoration: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('order.payment') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        <div class="page-header mb-0">
            Select Address
            <span class="address-count">({{ $addressCount }}/3)</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse($addresses as $address)
        <form action="{{ route('order.address.save') }}" method="POST">
            @csrf
            <input type="hidden" name="id_address" value="{{ $address->id_address }}">
            <input type="hidden" name="full_address" value="{{ $address->full_address }}">
            <input type="hidden" name="map_point" value="{{ $address->map_point }}">
            <input type="hidden" name="address_contact_number" value="{{ $address->address_contact_number }}">
            
            <div class="address-card {{ session('selected_address') == $address->id_address ? 'selected' : '' }}">
                <!-- Delete button (only if more than 1 address) -->
                @if($addressCount > 1)
                    <button type="button" class="delete-btn" 
                            onclick="event.preventDefault(); event.stopPropagation(); deleteAddress({{ $address->id_address }})"
                            title="Delete address">
                        <i class="bi bi-trash"></i>
                    </button>
                @endif

                <button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 0;">
                    <h6 style="font-weight: 600; margin-bottom: 8px;">Delivery Address</h6>
                    <p style="margin-bottom: 8px; color: #2D2D2D;">{{ $address->full_address }}</p>
                    @if($address->address_contact_number)
                        <p class="text-muted mb-0" style="font-size: 14px;">Contact: {{ $address->address_contact_number }}</p>
                    @endif
                </button>

                <!-- Edit link at bottom -->
                <a href="{{ route('order.address.details', $address->id_address) }}" 
                   class="edit-link" 
                   onclick="event.stopPropagation();">
                    <i class="bi bi-pencil-square"></i> Edit Address
                </a>
            </div>
        </form>
    @empty
        <div class="text-center py-4">
            <p class="text-muted">You don't have any saved addresses</p>
        </div>
    @endforelse

    <a href="{{ route('order.address.details') }}" 
       class="btn add-address-btn {{ !$canAddMore ? 'disabled' : '' }}"
       @if(!$canAddMore) disabled @endif>
        <i class="bi bi-plus-circle me-2"></i>
        {{ $addressCount > 0 ? 'Add New Address' : 'Add Address' }}
        @if(!$canAddMore)
            <span class="d-block" style="font-size: 12px; margin-top: 4px;">Maximum 3 addresses reached</span>
        @endif
    </a>
</div>

<!-- Hidden delete forms -->
@foreach($addresses as $address)
    <form id="deleteForm{{ $address->id_address }}" 
          action="{{ route('order.address.delete', $address->id_address) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<script>
function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address?')) {
        document.getElementById('deleteForm' + addressId).submit();
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
