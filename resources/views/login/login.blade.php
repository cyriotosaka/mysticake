<!---Updated by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MystiCake</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head> 
<body>
    <div class="header-nav">
        <a href="{{ route('landing') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="brand-title" style="font-size: 1.5rem; margin: 0 auto; padding-right: 24px;">MYstiCake</span>
    </div>

    <div class="container px-4 mt-3">
        <h1 class="page-title">LOGIN</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="custom-input-group">
                <label class="custom-label">Email</label>
                <input type="email"
                name="email" 
                class="form-control custom-field" 
                placeholder="Type here" 
                value="{{ session('last_email') ?? old('email') }}" 
                required>
            </div>

            <div class="custom-input-group">
                <label class="custom-label">Password</label>
                <input type="password" name="password" class="form-control custom-field" placeholder="Type here" required>
            </div>

            <div class="mt-5">
                <button type="submit" class="btn btn-custom">Login</button>
            </div>
        </form>

        <div class="footer-text">
            Don't have an account? <br>
            <a href="{{ route('register') }}" class="register-link">Register</a>
        </div>
    </div>

</body>
</html> 
