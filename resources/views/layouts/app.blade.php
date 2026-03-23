<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Tecci')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                <span class="logo-text">TECCI</span>
            </a>

            {{-- Navigation --}}
            <nav class="main-nav">
                <ul>
                    {{-- Home: Uses route('home') --}}
                    <li>
                        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">Home</a>
                    </li>
                    
                    {{-- About: Uses url('/about-us') because it has no name in web.php --}}
                    <li>
                        <a href="{{ url('/about-us') }}" class="{{ Request::is('about-us') ? 'active' : '' }}">About</a>
                    </li>
                    
                    {{-- Contact: Uses route('contact.form') --}}
                    <li>
                        <a href="{{ route('contact.form') }}" class="{{ Request::routeIs('contact.form') ? 'active' : '' }}">Contact</a>
                    </li>
                    
                    {{-- Products: Uses route('products.index') --}}
                    <li>
                        <a href="{{ route('products.index') }}" class="{{ Request::routeIs('products.index') ? 'active' : '' }}">Products</a>
                    </li>
                </ul>
            </nav>

            {{-- Icons --}}
            <div class="nav-icons">
                {{-- Order History: Placeholder --}}
                <a href="my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
                
                {{-- Basket Icon with Notification Badge --}}
                <a href="{{ route('basket.index') }}" class="cart-icon-wrapper">
                    <i class="fa-solid fa-cart-shopping"></i>
    
                    {{-- Get basket count from DB instead of session --}}
                    @php
                        use App\Models\BasketItem;
                        
                        // Get total quantity from database
                        if (Auth::check()) {
                            // For logged-in users
                            $basketCount = BasketItem::where('user_id', Auth::id())->sum('quantity');
                        } else {
                            // For guests
                            $basketCount = BasketItem::where('session_id', session()->getId())->sum('quantity');
                        }
                    @endphp
                    
                    {{-- Only show badge if there are items --}}
                    @if($basketCount > 0)
                        <span class="cart-badge">{{ $basketCount }}</span>
                    @endif
                </a>
                
                {{-- Login: Uses route('login') --}}
                <a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a>
            </div>

        </div>
    </header>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- GLOBAL FOOTER (Updated from Display Products Page) --}}
    <footer class="site-footer">
        <div class="container footer-inner"> <div class="footer-col">
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
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about-us') }}">About</a></li>
                    <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('basket.index') }}">Basket</a></li>
                    <li><a href="{{ url('/login') }}">My Account</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact Info</h4>
                <ul class="contact-list">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>0121 555 0198</span><br><br>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>Tecci_Queries@net.com</span><br><br>
                    </li>
                    <li>
                        <i class="fa-regular fa-envelope"></i>
                        <span>Birmingham, B4 7ET</span><br><br>
                    </li>
                </ul>
            </div>
        </div> 

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Tecci. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>