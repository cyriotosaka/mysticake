<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MystiCake Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    @include('partials.theme-script')

    <style>
        :root {
            --bg-color: #FFF0F3;     /* Background pink muda */
            --btn-color: #ED7A8D;    /* Button pink tua */
            --btn-hover: #D96C7F;   /* Button hover */
            --text-light: #F8C3CD;   /* Teks "Don't have an account?" */
            --text-white: #FFFFFF;
        }

        body, html {
            height: 100%;
            margin: 0;
        }

        body {
            background-color: var(--bg-color);
            /* Menggunakan 'Poppins' sebagai font sans-serif utama */
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 420px; /* Mensimulasikan lebar layar ponsel */
            width: 100%;
            padding: 2rem 1.5rem;
        }

        .app-title {
            /* Menggunakan 'Lora' sebagai font serif untuk judul */
            font-family: 'Lora', serif;
            font-weight: 700;
            font-size: 3.5rem; /* Ukuran font besar untuk "MYstiCake" */
            color: var(--text-white);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .slogan {
            font-size: 1rem;
            color: var(--text-white);
            margin-top: -0.5rem; /* Menarik slogan lebih dekat ke judul */
        }

        .illustration {
            width: 100%;
            max-width: 280px; /* Mengatur ukuran gambar ilustrasi */
            margin-top: 1.5rem;
            margin-bottom: 2.5rem;
        }

        /* Styling untuk Button Login */
        .btn-login {
            background-color: var(--btn-color);
            border: none;
            color: var(--text-white);
            font-size: 1.1rem;
            font-weight: 500;
            padding: 0.8rem 0;
            /* Memberi bayangan agar tombol terlihat "pop" */
            box-shadow: 0 4px 12px rgba(237, 122, 141, 0.4);
            transition: all 0.2s ease-in-out;
        }

        .btn-login:hover {
            background-color: var(--btn-hover);
            color: var(--text-white);
            transform: translateY(-2px); /* Efek sedikit terangkat saat hover */
        }

        /* Styling untuk link Register */
        .register-link {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--btn-color);
            font-weight: 500;
            text-decoration: underline; /* Sesuai gambar, linknya bergaris bawah */
            text-decoration-color: var(--btn-color);
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }

        .register-link a:hover {
            color: var(--btn-hover);
            text-decoration-color: var(--btn-hover);
        }

    </style>
</head>
<body class="text-center">

    <div class="login-container">
        <h1 class="app-title">MYstiCake</h1>
        <p class="slogan">Dessert for all happiness</p>

        <img src="https://via.placeholder.com/300x200.png?text=Ganti+dengan+Ilustrasi+Anda"
             alt="MystiCake Illustration"
             class="illustration">

        <div class="d-grid px-3">
            <a href="#" class="btn btn-login rounded-pill">Login</a>
        </div>

        <p class="mt-4 register-link">
            Don't have an account? <a href="#">Register</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
