<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Details - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @include('partials.theme-script')
    <style>
        body {
            background: #FFF5F7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .page-header {
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0;
            color: #2D2D2D;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .form-label {
            font-weight: 600;
            color: #2D2D2D;
            margin-bottom: 8px;
        }

        .form-control, .form-control:focus {
            border: 1.5px solid #E0E0E0;
            border-radius: 10px;
            padding: 12px;
        }

        .form-control:focus {
            border-color: #E66A7F;
            box-shadow: 0 0 0 0.2rem rgba(230, 106, 127, 0.1);
        }

        .save-btn {
            width: 100%;
            background: linear-gradient(135deg, #E66A7F 0%, #D95570 100%);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 12px rgba(230, 106, 127, 0.3);
            margin-top: 20px;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(230, 106, 127, 0.4);
        }

        .back-btn {
            color: #2D2D2D;
            font-size: 24px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container px-3 pt-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('order.address.select') }}" class="back-btn me-3"><i class="bi bi-arrow-left"></i></a>
        <div class="page-header mb-0">Address Details</div>
    </div>

    <div class="form-card">
        <form action="{{ route('order.address.save') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="full_address" class="form-label">Full Address</label>
                <textarea class="form-control" id="full_address" name="full_address" 
                          rows="3" required placeholder="Enter your complete delivery address">{{ old('full_address', $address->full_address ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="map_point" class="form-label">Map Point (Optional)</label>
                <input type="text" class="form-control" id="map_point" name="map_point" 
                       value="{{ old('map_point', $address->map_point ?? '') }}"
                       placeholder="e.g., -6.2000,106.8166">
                <small class="text-muted">Format: latitude,longitude</small>
            </div>

            <div class="mb-3">
                <label for="address_contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="address_contact_number" 
                       name="address_contact_number" required
                       value="{{ old('address_contact_number', $address->address_contact_number ?? '') }}"
                       placeholder="Enter phone number">
            </div>

            <button type="submit" class="save-btn">
                <i class="bi bi-check-circle me-2"></i>Save Address
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
