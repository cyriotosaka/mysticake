<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MYstiCake</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100 text-center bg-pink">
    <!-- Logo / Title -->
    <h1 class="brand-title mt-4">MYstiCake</h1>
    <p class="brand-subtitle mb-4">Dessert for all happiness</p>

    <!-- Illustration -->
    <img src="{{ asset('images/cake-illustration.png') }}" alt="Cute Dessert" class="img-fluid illustration mb-4">

    <!-- Login Button -->
    <button class="btn btn-login px-5 py-2 mb-3">Login</button>

    <!-- Register Link -->
    <p class="text-muted small">
      Don’t have an account? 
      <a href="#" class="register-link">Register</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>