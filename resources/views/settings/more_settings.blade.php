<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>More Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
</head>
<body>
    <div class="container pt-3">
        <div class="header-nav">
            <a href="{{ route('settings.profile') }}"><i class="bi bi-arrow-left fs-4"></i></a>
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
                <p>Manage the app display just the way you like it</p>
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
            <div class="menu-icon"><i class="bi bi-key"></i></div>
            <div class="menu-content">
                <h5>Change Password</h5>
                <p>Change or reset your password at any time</p>
            </div>
        </a>

        <div class="mt-5">
            <button class="btn btn-pink-light">Switch Account</button>
            <a href="{{ route('logout') }}" class="btn btn-pink d-block text-center">Log Out</a>
        </div>
    </div>

    <div class="modal fade" id="languageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-3">
                <h5 class="text-center mb-4">Change Language</h5>
                <div class="modal-option">
                    <span><i class="bi bi-translate me-2"></i> English (EN)</span>
                    <input class="form-check-input" type="radio" name="lang" checked>
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-translate me-2"></i> Bahasa Indonesia (ID)</span>
                    <input class="form-check-input" type="radio" name="lang">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="themeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-3">
                <h5 class="text-center mb-4">Change Theme</h5>
                <div class="modal-option">
                    <span><i class="bi bi-moon-fill me-2"></i> Dark</span>
                    <input class="form-check-input" type="radio" name="theme">
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-brightness-high-fill me-2"></i> Light</span>
                    <input class="form-check-input" type="radio" name="theme" checked>
                </div>
                <div class="modal-option">
                    <span><i class="bi bi-phone me-2"></i> Use device setting</span>
                    <input class="form-check-input" type="radio" name="theme">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom p-3" style="background-color: #FFFDF5; color: #333;">
                <h6 class="mb-3 fw-bold">Please tell us more so we can improve our service</h6>

                <div class="d-grid gap-2 mb-4">
                    <button class="btn btn-danger text-start">I found a better service</button>
                    <button class="btn btn-danger text-start">Privacy concern</button>
                    <button class="btn btn-danger text-start">Other reason</button>
                </div>

                <button class="btn btn-pink w-100 mb-2">Submit</button>
                <button class="btn btn-outline-danger w-100" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
