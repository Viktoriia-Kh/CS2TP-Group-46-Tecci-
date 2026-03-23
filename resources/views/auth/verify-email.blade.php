<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="{{ asset('loginstyle.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="signup-page">

    <header class="main-header">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span>TECCI</span>
            </a>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Products</a></li>

                    <!--Added A Dark/Light Mode Toggle Button-->
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Switch to dark mode">
                    <i class="fa-solid fa-moon"></i>
                    <!--fa-moon is a Moon Icon linked from Font Awesome-->
                    <!--class="theme-toggle" lets us style the button using CSS-->
                    <!--id="themeToggle" allows us to use this id in JavaScript-->
                </button>
                </ul>
            </nav>

            <div class="nav-icons">
                <a href="#"><i class="fa fa-history" aria-hidden="true"></i></a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="#"><i class="fa-regular fa-user"></i></a>
            </div>
        </div>
    </header>

   <main class="signup-main">
    <div class="signup-card verify-card">

        <div class="signup-header" style="text-align:center;">
            <h1>Verify your email</h1>
            <p>
                We’ve sent a verification link to<br>
                <strong>{{ auth()->user()->email }}</strong>.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert-success">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="signup-form">
            @csrf
            <button type="submit" class="signup-submit-btn">
                Resend Verification Email
            </button>
        </form>

        <div class="verify-user">
            Logged in as <strong>{{ auth()->user()->name }}</strong>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Log out
                </button>
            </form>
        </div>

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

</body>
</html>