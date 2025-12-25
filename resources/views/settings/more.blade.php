<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More Settings - MystiCake</title>
    
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Created by Lailatul Fitaliqoh (5026231229) */
        body {
            background-color: #FFFDF5; 
            font-family: 'Instrument Sans', sans-serif;
            color: #4A4A4A;
        }

        .container {
            max-width: 480px; 
        }

        /* Header Styles */
        .header-nav {
            display: flex;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .back-btn {
            font-size: 24px;
            color: #333;
            text-decoration: none;
            margin-right: 15px;
        }

        .header-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #4E342E;
            flex-grow: 1;
            text-align: center;
            margin-right: 24px; /* Balancing the back button space */
        }

        /* Menu Card Styles */
        .menu-card {
            background-color: #FFF8F0; 
            border-radius: 16px;
            padding: 15px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            border: 1px solid #FBE9E7;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-2px);
            background-color: #fff;
        }

        .menu-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
            color: #D65A6E; /* Warna ikon pink tua */
        }

        .menu-content h5 {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
            color: #4E342E;
        }

        .menu-content p {
            font-size: 11px;
            color: #8D8D8D;
            margin: 2px 0 0 0;
            line-height: 1.2;
        }

        /* Modal Styles */
        .modal-content-custom {
            border-radius: 20px;
            border: none;
            background-color: #FFF8F0;
        }

        .modal-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            background: white;
            margin-bottom: 10px;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #eee;
        }

        /* Action Buttons (Bottom) */
        .action-btn {
            display: block;
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            border: none;
            margin-bottom: 15px;
            font-size: 15px;
            transition: background 0.3s;
        }

        .btn-switch {
            background-color: #F06A7D;
            color: white;
        }
        .btn-switch:hover {
            background-color: #d65a6e;
            color: white;
        }

        .btn-logout {
            background-color: #F06A7D;
            color: white;
        }
        .btn-logout:hover {
            background-color: #d65a6e;
            color: white;
        }

        /* Delete Account Radio Styles */
        .delete-reason-option {
            display: flex;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 10px;
            margin-bottom: 8px;
            border: 1px solid #eee;
        }
        .delete-reason-option input {
            margin-right: 10px;
            accent-color: #F06A7D;
        }

        /* SWITCH ACCOUNT */
        .account-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background 0.2s;
            background-color: white;
            border: 1px solid #f0f0f0;
        }

        .account-item:hover {
            background-color: #fff5f5; /* Efek hover pink tipis */
        }

        .active-account {
            border: 1px solid #F06A7D; /* Border pink untuk akun aktif */
            background-color: #fff0f3;
        }

        .account-img-wrapper {
            width: 40px;
            height: 40px;
            margin-right: 12px;
        }

        .account-img-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .default-avatar {
            width: 100%;
            height: 100%;
            background-color: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .account-info {
            display: flex;
            flex-direction: column;
        }

        .account-name {
            font-weight: 700;
            font-size: 14px;
            color: #4E342E;
        }

        .account-email {
            font-size: 11px;
            color: #888;
        }

        .add-account-btn {
            display: block;
            text-align: center;
            color: #D65A6E;
            font-weight: 600;
            text-decoration: none;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
        }
        .add-account-btn:hover {
            background-color: #fff0f3;
            color: #c2185b;
        }
    </style>
</head>
<body>

    <div class="container px-4">
        
        <div class="header-nav">
            <a href="{{ route('settings.profile') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="header-title">Account and App Setting</div>
        </div>

        <div class="menu-card" data-bs-toggle="modal" data-bs-target="#languageModal">
            <div class="menu-icon"><i class="bi bi-globe"></i></div>
            <div class="menu-content">
                <h5>Change language</h5>
                <p>Pick the language setting you'd like to use here</p>
            </div>
        </div>

        <div class="menu-card" data-bs-toggle="modal" data-bs-target="#themeModal">
            <div class="menu-icon"><i class="bi bi-palette"></i></div>
            <div class="menu-content">
                <h5>Change theme</h5>
                <p>Manage the app display just the way you like it -- light or dark</p>
            </div>
        </div>

        <div class="menu-card" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <div class="menu-icon"><i class="bi bi-person-x-fill"></i></div>
            <div class="menu-content">
                <h5>Delete Account</h5>
                <p>Find out how you can delete your account</p>
            </div>
        </div>

        <div class="menu-card">
            <div class="menu-icon"><i class="bi bi-phone"></i></div>
            <div class="menu-content">
                <h5>Login History</h5>
                <p>To track account activities on your devices</p>
            </div>
        </div>

        <a href="{{ route('settings.password') }}" class="menu-card">
            <div class="menu-icon"><i class="bi bi-shield-lock-fill"></i></div> <div class="menu-content">
                <h5>Change Password</h5>
                <p>Change or reset your password at any time</p>
            </div>
        </a>

        <div style="height: 30px;"></div>

        <button class="action-btn btn-switch" data-bs-toggle="modal" data-bs-target="#switchAccountModal">
            Switch Account
        </button>

        <form id="logout-form-settings" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button onclick="event.preventDefault(); document.getElementById('logout-form-settings').submit();" class="action-btn btn-logout">
            Log Out
        </button>

        <div style="height: 50px;"></div>
    </div>

    <div class="modal fade" id="languageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-3">
                <h5 class="text-center mb-4 fw-bold" style="color: #4E342E;">Change Language</h5>
                <div class="modal-option">
                    <span><i class="bi bi-translate me-2 text-danger"></i> English (EN)</span>
                    <input class="form-check-input" type="radio" name="lang" checked>
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-translate me-2 text-danger"></i> Bahasa Indonesia (ID)</span>
                    <input class="form-check-input" type="radio" name="lang">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="themeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-3">
                <h5 class="text-center mb-4 fw-bold" style="color: #4E342E;">Change Theme</h5>
                <div class="modal-option">
                    <span><i class="bi bi-moon-fill me-2 text-danger"></i> Dark</span>
                    <input class="form-check-input" type="radio" name="theme">
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-brightness-high-fill me-2 text-danger"></i> Light</span>
                    <input class="form-check-input" type="radio" name="theme" checked>
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-phone me-2 text-danger"></i> Use device setting</span>
                    <input class="form-check-input" type="radio" name="theme">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-4">
                <h6 class="mb-3 fw-bold text-center" style="color: #4E342E;">Please tell us more so we can improve our service</h6>

                <form>
                    <label class="delete-reason-option">
                        <input type="radio" name="delete_reason" value="better_service">
                        <span>I found a better service</span>
                    </label>
                    
                    <label class="delete-reason-option">
                        <input type="radio" name="delete_reason" value="privacy">
                        <span>Privacy concern</span>
                    </label>
                    
                    <label class="delete-reason-option">
                        <input type="radio" name="delete_reason" value="other">
                        <span>Other reason</span>
                    </label>

                    <div class="mt-4">
                        <button type="button" class="btn btn-switch w-100 mb-2">Submit</button>
                        <button type="button" class="btn w-100" style="color: #F06A7D; font-weight: 600;" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="modal fade" id="switchAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom p-4">
            <h5 class="text-center mb-4 fw-bold" style="color: #4E342E;">Switch Account</h5>

            <div id="account-list-container">
                </div>

            <hr style="opacity: 0.1; margin: 15px 0;">

            <form id="switch-account-form" action="{{ route('auth.switch') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="email" id="target_email"> 
            </form>

            <a href="#" class="add-account-btn" onclick="event.preventDefault(); document.getElementById('switch-account-form').submit();">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-plus-circle"></i> Log into an existing account
                </div>
            </a>
        </div>
    </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil data user yang sedang aktif sekarang dari PHP
        const currentEmail = "{{ Auth::user()->email }}";
        
        // 2. Ambil history dari LocalStorage browser
        const history = JSON.parse(localStorage.getItem('mysticake_login_history')) || [];
        const container = document.getElementById('account-list-container');

        // 3. Render HTML untuk setiap akun
        if (history.length === 0) {
            // Jika kosong (baru pertama kali buka app)
            container.innerHTML = '<p class="text-center text-muted small">No other accounts saved.</p>';
        } else {
            container.innerHTML = ''; // Kosongkan wadah
            
            history.forEach(user => {
                const isActive = (user.email === currentEmail);
                
                // Tentukan gambar avatar (pakai icon default jika kosong)
                let imgHtml = '';
                if (user.avatar) {
                    imgHtml = `<img src="${user.avatar}" alt="Profile" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">`;
                } else {
                    imgHtml = `<div class="default-avatar" style="width:100%; height:100%; background:#ddd; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white;"><i class="bi bi-person-fill"></i></div>`;
                }

                // Buat elemen HTML Item Akun
                const itemDiv = document.createElement('div');
                itemDiv.className = `account-item ${isActive ? 'active-account' : ''}`;
                itemDiv.style.cssText = "display: flex; justify-content: space-between; align-items: center; padding: 12px; border-radius: 12px; margin-bottom: 8px; cursor: pointer; background-color: white; border: 1px solid #f0f0f0;";
                
                if (isActive) {
                    itemDiv.style.borderColor = "#F06A7D";
                    itemDiv.style.backgroundColor = "#fff0f3";
                } else {
                    // Jika diklik akun lain -> Logout & Redirect Login
                    itemDiv.onclick = function() {
                        if(confirm('Switch to ' + user.username + '?')) {
                            document.getElementById('target_email').value = user.email;
                            document.getElementById('switch-account-form').submit();
                        }
                    };
                }

                itemDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="account-img-wrapper" style="width: 40px; height: 40px; margin-right: 12px;">
                            ${imgHtml}
                        </div>
                        <div class="account-info">
                            <div class="account-name" style="font-weight: 700; font-size: 14px; color: #4E342E;">${user.username}</div>
                            <div class="account-email text-truncate" style="font-size: 11px; color: #888; max-width: 150px;">${user.email}</div>
                        </div>
                    </div>
                    ${isActive ? '<i class="bi bi-check-circle-fill text-success fs-5"></i>' : ''}
                `;

                container.appendChild(itemDiv);
            });
        }
    });
    </script>
</body>
</html>