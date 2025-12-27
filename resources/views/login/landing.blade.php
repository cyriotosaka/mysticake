<!-- Created by Arsya Nueva_099 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MystiCake - Welcome</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @include('partials.theme-script')

    <style>
        body {
            background: linear-gradient(180deg, #fcb4c2 0%, #f8d4d9 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .mobile-container {
            width: 100%;
            max-width: 380px;
            padding: 20px;
        }

        .brand-title {
            font-weight: 700;
            font-size: 36px;
            color: white;
            text-shadow: 0px 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }

        .subtitle {
            color: white;
            font-size: 16px;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .image-box img {
            max-width: 100%;
            height: auto;
            drop-shadow: 0px 5px 15px rgba(0,0,0,0.1);
            width: 300px;
            margin-bottom: 30px;
        }

        .login-btn {
            background-color: #e9687c;
            color: white;
            border-radius: 50px;
            width: 75%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            box-shadow: 0px 5px 15px rgba(233, 104, 124, 0.4);
            transition: transform 0.2s;
            display: block;
            text-decoration: none;
            margin: 0 auto;
        }

        .login-btn:hover {
            background-color: #d65a6e;
            color: white;
            transform: scale(1.02);
        }

        .register-text {
            color: white;
            margin-top: 15px;
            font-size: 13px;
        }

        .register-text a {
            font-weight: 700;
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="mobile-container text-center">

        <h1 class="brand-title">MYstiCake</h1>
        <p class="subtitle">Dessert for all happiness</p>

        <div class="image-box">
            <img src="{{ asset('images/Mysticake_logo.png') }}" alt="Logo" width="280">
        </div>

        <a href="{{ route('login') }}" class="login-btn">Login</a>

        <p class="register-text">Don’t have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>

    </div>

</body>
</html>
