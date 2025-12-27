<!---Created by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    @include('partials.theme-script')
    <style>
        /* Custom Input Password Box (Dark Brown) */
        .pwd-box {
            background-color: #3E2723;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .pwd-input {
            background: transparent;
            border: none;
            color: white;
            width: 100%;
            outline: none;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.5);
            padding-bottom: 5px;
        }
        .pwd-input::placeholder { color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>
    <div class="container pt-3">
        <div class="header-nav">
            <a href="{{ route('settings.more') }}"><i class="bi bi-arrow-left fs-4"></i></a>
            <div class="header-title">Change Password</div>
        </div>

        <form>
            <label class="form-label">Enter your current Password</label>
            <div class="pwd-box">
                <input type="password" class="pwd-input" placeholder="This is to verify that is really you">
                <i class="bi bi-eye-fill"></i>
            </div>

            <label class="form-label">Enter your new Password</label>
            <div class="pwd-box">
                <input type="password" class="pwd-input" placeholder="Type here">
                <i class="bi bi-eye-fill"></i>
            </div>

            <label class="form-label">Confirm Password</label>
            <div class="pwd-box">
                <input type="password" class="pwd-input" placeholder="Retype your new password">
                <i class="bi bi-eye-fill"></i>
            </div>

            <a href="#" class="text-danger text-decoration-underline mb-5 d-block" data-bs-toggle="toast" data-bs-target="#forgotToast" onclick="showToast()">Forgot Password</a>

            <div class="mt-5">
                <button class="btn btn-pink" style="background-color: #3E2723;">Confirm</button>
            </div>
        </form>
    </div>

    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
        <div id="forgotToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    We have sent an email to {{ Auth::user()->email }} containing a link to reset your password.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showToast() {
            const toastLiveExample = document.getElementById('forgotToast')
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    </script>
</body>
</html>
