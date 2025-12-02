<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify your email | Tecci</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

            {{-- Navigation --}}
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ route('signup.form') }}">Sign up</a></li>
                </ul>
            </nav>

            {{-- Icons --}}
            <div class="nav-icons">
                <a href="#">🔍</a>
                <a href="#">🛒</a>
            </div>

        </div>
    </header>

    {{-- Main Content --}}
    <main class="signup-main">
        <div class="signup-card">

            <div class="signup-header">
                <h1>Verify your email</h1>
                <p>
                    We’ve sent a verification link to
                    <strong>{{ auth()->user()->email }}</strong>.
                    Please click the link in that email to activate your account.
                </p>
            </div>

            {{-- Status: link re-sent --}}
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Resend button --}}
            <form method="POST" action="{{ route('verification.send') }}" class="signup-form">
                @csrf
                <button type="submit" class="signup-submit-btn">
                    Resend verification email
                </button>
            </form>

            <p class="signup-footer-text">
                Logged in as {{ auth()->user()->name }} –
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
            </p>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="main-footer">
        <div class="container footer-inner">
            <p class="footer-copy">© {{ date('Y') }} Tecci. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Support</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
