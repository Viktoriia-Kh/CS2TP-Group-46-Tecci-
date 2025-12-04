<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Sign Up | Tecci</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="signup-page">

    {{-- HEADER --}}
    <header class="main-header">
        <div class="container nav-container">

            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span class="logo-text">TECCI</span>
            </a>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="#" class="active">Products</a></li>
                </ul>
            </nav>

            <div class="nav-icons">
                <a href="#"><i class="fa-regular fa-heart"></i></a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="#"><i class="fa-regular fa-user"></i></a>
            </div>

        </div>
    </header>

    {{-- SIGNUP CARD --}}
    <main class="signup-main">
        <div class="signup-card">

            <div class="signup-header">
                <h1>Create your account</h1>
                <p>Sign up for your Tecci Shop account</p>
            </div>

            {{-- Social Buttons --}}
            <div class="social-buttons">
                <a href="{{ route('auth.google') }}" class="social-btn">Continue with Google</a>
                <a href="{{ route('auth.microsoft') }}" class="social-btn">Continue with Microsoft</a>
            </div>

            <div class="signup-divider">Or continue with</div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('signup.submit') }}" method="POST" class="signup-form">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input name="name" id="name" type="text" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input name="email" id="email" type="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" id="password" type="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" required>
                </div>

                <button type="submit" class="signup-submit-btn">Create Account</button>
            </form>

            <p class="signup-footer-text">
                Already have an account?
                <a href="#">Login</a>
            </p>

        </div>
    </main>

   <footer class="main-footer">
    <div class="container footer-inner">
        <div class="footer-col">
            <h3>TECCI</h3>
            <p>
                Smart Tech at Smart Prices.<br>
                Tecci makes premium devices accessible to<br>
                students and customers across the UK.
            </p>
        </div>

        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="/basket">Basket</a></li>
                <li><a href="/account">My Account</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="contact-list">
                <li><i class="fa-solid fa-location-dot"></i> Birmingham, B4 7ET</li>
                <li><i class="fa-solid fa-phone"></i> 0121 555 0198</li>
                <li><i class="fa-regular fa-envelope"></i> Tecci_Queries@net.com</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; 2025 Tecci. All rights reserved.
    </div>
</footer>
