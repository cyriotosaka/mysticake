<!---Created by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - MystiCake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #FFFDF5; 
            font-family: 'Instrument Sans', sans-serif;
            color: #4A4A4A;
        }

        .header-nav {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .back-btn {
            font-size: 24px;
            color: #333;
            text-decoration: none;
        }

        .page-title {
            flex-grow: 1;
            text-align: center;
            font-weight: 700;
            font-size: 18px;
            margin-right: 24px; 
        }

        .profile-pic-wrapper {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #ff8fa3;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .upload-text {
            display: block;
            margin-top: 10px;
            color: #ff6b83;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .form-label {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        .custom-input {
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
            background: transparent;
            padding-left: 0;
            font-weight: 500;
        }

        .custom-input:focus {
            background: transparent;
            box-shadow: none;
            border-bottom: 2px solid #ff6b83;
        }

        .input-group-text {
            background: transparent;
            border: none;
            border-bottom: 1px solid #ccc;
        }

        .btn-menu-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ff6b83; /* Warna Pink Utama */
            color: white;
            border-radius: 25px;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 15px;
            border: none;
            width: 100%;
        }

        .btn-menu-link:hover {
            background-color: #ff5270;
            color: white;
        }

        .more-setting-link {
            color: #ff6b83;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-bottom: 30px;
        }

        .btn-save {
            background-color: #ff6b83;
            color: white;
            border-radius: 25px;
            padding: 12px 40px;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 15px rgba(255, 107, 131, 0.4);
            display: block;
            width: 150px;
            margin: 0 auto 30px auto;
        }

        .btn-save:hover {
            background-color: #ff5270;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="container" style="max-width: 480px;">
        <div class="header-nav">
            <a href="{{ route('home') }}" class="back-btn"><i class="bi bi-arrow-left"></i></a>
            <span class="page-title">Edit Profile</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-3 rounded-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="px-4">
            @csrf
            
            <div class="profile-pic-wrapper">
                @if($user->profile_picture)
                    <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="profile-img" id="previewImg">
                @else
                    <div class="profile-img d-flex align-items-center justify-content-center mx-auto text-white fs-1">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
                
                <label for="profile_picture" class="upload-text">Add/change profile photo</label>
                <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*" onchange="previewFile()">
            </div>

            <div class="mb-4">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" name="username" class="form-control custom-input" value="{{ old('username', $user->username) }}" required>
                    <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Phone number</label>
                <div class="input-group">
                    <input type="text" name="phone_number" class="form-control custom-input" value="{{ old('phone_number', $user->phone_number) }}" required>
                    <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control custom-input" value="{{ old('email', $user->email) }}" required>
                    <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                </div>
            </div>

            <a href="{{ route('address.index') }}" class="btn-menu-link">
                My Address <i class="bi bi-chevron-right"></i>
            </a>

            <div class="dropdown mb-3 w-100">
                <button class="btn-menu-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="justify-content: space-between;">
                    Role: {{ ucfirst($user->role) }}
                </button>
                <ul class="dropdown-menu w-100 border-0 shadow rounded-4">
                    <li><button class="dropdown-item py-2" type="button" onclick="setRole('buyer')">Buyer</button></li>
                    <li><button class="dropdown-item py-2" type="button" onclick="setRole('seller')">Seller</button></li>
                </ul>
                <input type="hidden" name="role" id="roleInput" value="{{ $user->role }}">
            </div>

            <a href="{{ route('settings.more') }}" class="more-setting-link">More Setting</a>

            <button type="submit" class="btn-save">Save</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewFile() {
            const preview = document.querySelector('img.profile-img');
            const placeholder = document.querySelector('div.profile-img');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                if(preview) {
                    preview.src = reader.result;
                } else if (placeholder) {
                    const newImg = document.createElement('img');
                    newImg.src = reader.result;
                    newImg.className = 'profile-img';
                    newImg.id = 'previewImg';
                    placeholder.parentNode.replaceChild(newImg, placeholder);
                }
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function setRole(role) {
            document.getElementById('roleInput').value = role;
        }
    </script>
</body>
</html>