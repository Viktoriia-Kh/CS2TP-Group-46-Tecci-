<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>
        <link rel="stylesheet" href="loginstyle.css"> <!-- created a link to the stylesheet-->
        <link rel="stylesheet" href="common-style.css">
        <!-- Google font -->
        <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
        <!-- Font awesome for icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    </head>

    <body>
        <header class="main-header">
            <div class="container nav-container">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                    <span class="logo-text">TECCI</span>
                </a>

                <!-- main nav bar-->
                <nav class="main-nav">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="about-us">About</a></li>
                        <li><a href="contact-us">Contact</a></li>
                        <li><a href="displayproduct">Products</a></li>
                    </ul>
                </nav>

                <!-- icons on the nav bar-->
                <div class="nav-icons">
                    <a href="#"><i class="fa-regular fa-heart"></i></a>
                    <a href="basket"><i class="fa-solid fa-cart-shopping"></i></a>
                    <a href="login"><i class="fa-regular fa-user"></i></a>
                </div>


            </div>
        </header>

        <section class="section-form">
            <h2>Reset Your Password</h2>
            <p class="welcome-sub-message">Enter your email address to reset your password.</p>

            {{-- This will display a success message to the user--}}
            @if (session('status'))
                <div class="success-messages">
                    {{session('status')}}
                </div>

            @endif




            {{-- This will display error messages to the user--}}
            @if (!empty($error_messages))
                <ul class="error-messages">
                    @foreach ($error_messages as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <!-- adding the form here for the user to fill in-->
            <form method="POST" action="{{url('/forgot-password')}}"> {{-- sends the email address to the forgot password route--}}
                @csrf {{-- this token is added for security of the form--}}

                <div>
                    <!-- this is where the user will enter the email address-->
                    <label for="email_address">Email address:</label>
                    <input type="email" name="email_address" id="email_address" required>
                </div>

                <button type="submit">Send Reset Link</button> <!-- sends the reset link once clicked-->

                <p class="signup-message">
                    <a href="{{ url('login')}}">Return to Login</a> <!-- this will redirect the user back to the login page-->
                </p>


            </form>

        </section>

   <!-- creating the footer-->
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
