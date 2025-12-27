<!--
 Final Project PPPL - MystiCake
 Semester Ganjil, 2024/2025
 Group Capstone Project
 Group #8
 5026231198 - Muhammad Fikri Khalilullah
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Mobile Site')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.theme-script')

    <style>
        /* Prevent screen from stretching too wide */
        body {
            max-width: 480px;
            margin: 0 auto;
            background: #f5f5f5;
        }

        /* Mobile bottom bar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: #fff;
            border-top: 1px solid #ddd;
            z-index: 999;
        }

        .bottom-nav a {
            flex: 1;
            padding: .7rem 0;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .bottom-nav a.active {
            color: #0d6efd;
            font-weight: 600;
        }
    </style>
</head>
<body>

    {{-- Top Navbar --}}
    @if(!isset($hide_nav) || !$hide_nav)
        <nav class="navbar bg-white border-bottom sticky-top">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h5">@yield('header', 'App')</span>
            </div>
        </nav>
    @endif

    {{-- Page Content --}}
    <main class="container py-3 mb-5">
        @yield('content')
    </main>

    {{-- Bottom Navigation --}}
    @if(!isset($hide_nav) || !$hide_nav)
        <nav class="bottom-nav d-flex">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <div><i class="bi bi-house"></i></div>
                Home
            </a>

            <a href="/messages" class="{{ request()->is('messages') ? 'active' : '' }}">
                <div><i class="bi bi-chat"></i></div>
                Messages
            </a>

            <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
                <div><i class="bi bi-person"></i></div>
                Profile
            </a>
        </nav>
    @endif

    {{-- Bootstrap JS Bundle with Popper --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>
</html>
