<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Sign Up | Tecci</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Google Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- Common styles FIRST -->
<link rel="stylesheet" href="{{ asset('common-style.css') }}">

<!-- Page specific styles SECOND -->
<link rel="stylesheet" href="{{ asset('css/sign-up2style.css') }}">
<link rel="stylesheet" href="Dark-Mode.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<!-- Chatbot CSS -->
<link rel="stylesheet" href="{{ asset('chatbot.css') }}">
</head>
<body class="signup-page">
    {{-- HEADER --}}
    <header class="main-header">
        <div class="container nav-container">

            <a href="/" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span class="logo-text">TECCI</span>
            </a>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="about-us">About</a></li>
                    <li><a href="contact-us">Contact</a></li>
                    <li><a href="displayproduct">Products</a></li>
                </ul>
            </nav>

            <div class="nav-icons">
                <a href="/my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
                <a href="basket"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login" class="active"><i class="fa-regular fa-user"></i></a>

                <!--Added A Dark/Light Mode Toggle Button-->
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Switch to dark mode">
                    <i class="fa-solid fa-moon"></i>
                    <!--fa-moon is a Moon Icon linked from Font Awesome-->
                    <!--class="theme-toggle" lets us style the button using CSS-->
                    <!--id="themeToggle" allows us to use this id in JavaScript-->
                </button>
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

                {{-- check if it is an admin signup--}}
                @if (Request::is('admin-signup'))
                    <input type="hidden" name="is_admin" value="1">
                @endif

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
                <a href="login">Login</a>
            </p>

        </div>
    </main>

   <footer class="site-footer">
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
                <li><a href="/">Home</a></li>
                <li><a href="/about-us">About</a></li>
                <li><a href="/contact-us">Contact</a></li>
                <li><a href="/displayproduct">Products</a></li>
                <li><a href="/basket">Basket</a></li>
                <li><a href="/login">My Account</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="contact-list">
                <li>
                    <i class="fa-solid fa-location-dot"></i> <!--fa-loocation-dot is a Location Icon linked from Font Awesome-->
                    <span>0121 555 0198</span><br><br>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
                    <span>Tecci_Queries@net.com</span><br><br>
                </li>
                <li>
                    <i class="fa-regular fa-envelope"></i> <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
                    <span>Birmingham, B4 7ET</span><br><br>
                </li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 Tecci. All rights reserved.</p>
    </div>
</footer>
    @include('partials.chatbot')
    <script src="{{ asset('chatbot.js') }}?v={{ time() }}">
    </script>
</body>
</html>

<script src="Dark-Mode-Theme.js"></script>