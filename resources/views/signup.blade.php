<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecci | Sign Up</title>

    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
</head>

<body class="signup-page">

    {{-- Global Header --}}
    <header class="main-header">
        <div class="container nav-container">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span>Tecci</span>
            </a>

            {{-- Main navigation --}}
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ route('signup.form') }}" class="active">Sign up</a></li>
                </ul>
            </nav>

            {{-- Icons (placeholder, swap for real icons later if you want) --}}
            <div class="nav-icons">
                <a href="#">🔍</a>
                <a href="#">🛒</a>
            </div>

        </div>
    </header>

    {{-- Page Content --}}
    <main class="signup-main">
        <div class="signup-card">

            <div class="signup-header">
                <h1>Create your account</h1>
                <p>Sign up for your Tecci Shop account</p>
            </div>

            {{-- Social Buttons --}}
            <div class="social-buttons">
                <a href="{{ route('auth.google') }}" class="social-btn">
                    Continue with Google
                </a>

                <a href="{{ route('auth.microsoft') }}" class="social-btn">
                    Continue with Microsoft
                </a>
            </div>

            <div class="signup-divider">Or continue with</div>

            {{-- Laravel Success Message --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Laravel Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SIGNUP FORM --}}
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

                <button type="submit" class="signup-submit-btn">
                    Create Account
                </button>
            </form>

            <p class="signup-footer-text">
                Already have an account?
                <a href="#">Login in</a>
            </p>

        </div>
    </main>

    {{-- Global Footer --}}
    <footer class="main-footer">
        <div class="container footer-inner">
            <p class="footer-copy">
                © {{ date('Y') }} Tecci. All rights reserved.
            </p>

            <ul class="footer-links">
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Support</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
