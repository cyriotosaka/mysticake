<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
</head>
<body>
    <div class="container pt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="header-nav">
            <a href="{{ route('home') }}"><i class="bi bi-arrow-left fs-4"></i></a>
            <div class="header-title">Edit Profile</div>
        </div>

        <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-pic-wrapper">
                @php
                    $pic = Auth::user()->profile_pic;
                    $picUrl = $pic && file_exists(public_path($pic)) ? asset($pic) : 'https://via.placeholder.com/100';
                    // Jika pakai storage link, sesuaikan path-nya
                    if($pic && str_contains($pic, 'storage')) {
                        $picUrl = asset($pic);
                    }
                @endphp
                <img src="{{ $picUrl }}" class="profile-pic" id="previewImg">

                <div class="change-photo-text" data-bs-toggle="offcanvas" data-bs-target="#photoBottomSheet">
                    Add/change profile photo
                </div>

                <input type="file" name="profile_pic" id="fileInput" class="d-none" accept="image/*" onchange="previewFile()">
            </div>

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control-underlined" value="{{ Auth::user()->username }}">
                <i class="bi bi-pencil-square edit-icon-input"></i>
            </div>

            <div class="form-group">
                <label class="form-label">Phone number</label>
                <input type="text" name="phone_number" class="form-control-underlined" value="{{ Auth::user()->phone_number }}">
                <i class="bi bi-pencil-square edit-icon-input"></i>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control-underlined" value="{{ Auth::user()->email }}">
                <i class="bi bi-pencil-square edit-icon-input"></i>
            </div>

            <a href="{{ route('address.index') }}" class="btn btn-pink d-flex justify-content-between align-items-center text-start mb-4">
                My Address <i class="bi bi-chevron-right"></i>
            </a>

            <div class="role-container">
                <div class="role-header">Role <i class="bi bi-chevron-down"></i></div>
                <div class="role-options">
                    <div class="form-check-custom">
                        <span class="form-check-label">Buyer</span>
                        <input class="form-check-input" type="radio" name="role" value="buyer" {{ Auth::user()->role == 'buyer' ? 'checked' : '' }}>
                    </div>
                    <div class="form-check-custom">
                        <span class="form-check-label">Seller</span>
                        <input class="form-check-input" type="radio" name="role" value="seller" {{ Auth::user()->role == 'seller' ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <a href="{{ route('settings.more') }}" class="d-block mb-5 text-decoration-underline text-danger fw-bold">More Setting</a>

            <div class="text-center pb-5">
                <button type="submit" class="btn btn-pink w-50">Save</button>
            </div>
        </form>
    </div>

    <div class="offcanvas offcanvas-bottom bottom-sheet-custom h-auto" tabindex="-1" id="photoBottomSheet">
        <div class="d-flex flex-column">
            <div class="sheet-btn text-center text-black" style="background: rgba(255,255,255,0.5); color: #333;">Edit Profile Picture</div>
            <button class="sheet-btn text-center" onclick="document.getElementById('fileInput').click()">Photos / Gallery</button>
            <button class="sheet-btn text-center">Camera</button>
            <button class="cancel-btn" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk preview gambar saat dipilih
        function previewFile() {
            const preview = document.getElementById('previewImg');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
                // Tutup bottom sheet setelah pilih gambar
                var bsOffcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('photoBottomSheet'));
                bsOffcanvas.hide();
            }
        }
    </script>
</body>
</html>
