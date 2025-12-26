<!---Created by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - MystiCake</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #FFFDF5; 
            font-family: 'Instrument Sans', sans-serif;
            color: #4E342E;
        }

        .container {
            max-width: 480px;
        }

        /* Header */
        .header-nav {
            display: flex;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .back-btn {
            font-size: 24px;
            color: #4E342E;
            text-decoration: none;
            margin-right: 15px;
        }
        .header-title {
            font-weight: 700;
            font-size: 1.1rem;
            flex-grow: 1;
            text-align: center;
            margin-right: 24px;
        }

        /* Form Label */
        .form-label {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
            color: #4E342E;
        }

        /* Input Styles */
        .input-group-custom {
            background-color: #3E2723; 
            border-radius: 50px; 
            padding: 5px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #3E2723;
        }

        .input-group-custom input {
            background: transparent;
            border: none;
            color: #FFF; /* Warna Putih */
            width: 100%;
            outline: none;
            font-size: 14px;
            padding: 10px 0;
        }

        .input-group-custom input::placeholder {
            color: #ACA19F; 
            font-size: 13px;
        }

        /* Eye Icon */
        .toggle-password {
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
        }

        /* Forgot Password Link */
        .forgot-link {
            color: #F06A7D; 
            font-size: 13px;
            font-weight: 600;
            text-decoration: underline;
            display: inline-block;
            margin-top: -10px;
            margin-bottom: 30px;
        }

        /* Confirm Button */
        .btn-confirm {
            background-color: #3E2723; 
            color: white;
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            margin-top: 40px; 
        }
        .btn-confirm:hover {
            background-color: #2b1b17;
            color: white;
        }

        /* Alert styling */
        .alert {
            border-radius: 12px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="container px-4">
        <div class="header-nav">
            <a href="{{ route('settings.more') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="header-title">Change Password</div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.updatePassword') }}" method="POST">
            @csrf
            
            <label class="form-label">Enter your current Password</label>
            <div class="input-group-custom">
                <input type="password" name="current_password" id="current_password" placeholder="This is to verify that is really you">
                <i class="bi bi-eye toggle-password" onclick="togglePassword('current_password', this)"></i>
            </div>

            <label class="form-label">Enter your new Password</label>
            <div class="input-group-custom">
                <input type="password" name="new_password" id="new_password" placeholder="Type here">
                <i class="bi bi-eye toggle-password" onclick="togglePassword('new_password', this)"></i>
            </div>

            <label class="form-label">Confirm Password</label>
            <div class="input-group-custom">
                <input type="password" name="new_password_confirmation" id="confirm_password" placeholder="Retype your new password">
                <i class="bi bi-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
            </div>

            <a href="#" class="forgot-link">Forgot Password</a>

            <button type="submit" class="btn-confirm">Confirm</button>
        </form>

        <div style="height: 50px;"></div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>
</body>
</html>