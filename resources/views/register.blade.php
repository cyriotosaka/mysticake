<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MystiCake</title>

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

    <div class="container px-4">
        <h1 class="page-title">Create Account</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="custom-input-group">
                <label class="custom-label">Email</label>
                <input type="email" name="email" class="form-control custom-field" placeholder="Type here" required>
            </div>

            <div class="custom-input-group">
                <label class="custom-label">Username</label>
                <input type="text" name="username" class="form-control custom-field" placeholder="Type here" required>
            </div>

            <div class="custom-input-group">
                <label class="custom-label">Password</label>
                <input type="password" name="password" class="form-control custom-field" placeholder="Type here" required>
            </div>

            <div class="custom-input-group">
                <label class="custom-label">Phone Number</label>
                <input type="tel" name="phone_number" class="form-control custom-field" placeholder="Type here">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-custom">Register</button>
            </div>
        </form>

        <div class="footer-text mb-4">
            Already have an account? <br>
            <a href="{{ route('login') }}" class="register-link">Login</a>
        </div>
    </div>

</body>
</html>
