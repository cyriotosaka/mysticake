<!DOCTYPE html>
<html lang="en">
<!-- Updated by Okky Priscila_168 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MYstiCake</title>
    <link rel="stylesheet" href="{{ asset('css/Register.css') }}">
    @include('partials.theme-script')
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('landing') }}" class="back-button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <!-- Logo -->
        <div class="logo">MYstiCake</div>

        <!-- Title -->
        <h1 class="title">Create Account</h1>

        <!-- Form -->
        <form action="{{ route('register.process') }}" method="POST" class="register-form">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Type here" 
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username Field -->
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Type here" 
                    value="{{ old('username') }}"
                    required
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Type here"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number Field -->
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone_number" 
                    name="phone_number" 
                    placeholder="Type here" 
                    value="{{ old('phone_number') }}"
                >
                @error('phone_number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="register-button">Register</button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            <p>Already have an account?</p>
            <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>