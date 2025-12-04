<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Tecci')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Global CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body @yield('body-class')>

    {{-- GLOBAL HEADER --}}
    <header class="main-header">
        <div class="container nav-container">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span class="logo-text">TECCI</span>
            </a>

            {{-- Navigation --}}
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="#" >About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Products</a></li>
                </ul>
            </nav>

            {{-- Icons --}}
            <div class="nav-icons">
                <a href="#"><i class="fa-regular fa-heart"></i></a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="#"><i class="fa-regular fa-user"></i></a>
            </div>

        </div>
    </header>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- GLOBAL FOOTER --}}
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
