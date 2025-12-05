<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="loginstyle.css"> <!-- created a link to the stylesheet-->
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
            <h2>Welcome Back</h2>
            <p class="welcome-sub-message">Login to your Tecci account.</p>
            {{-- This will display error messages to the user--}}
            @if (!empty($error_messages))
                <ul class="error-messages">
                    @foreach ($error_messages as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <!-- adding the login form here for the user to fill in-->
            <form method="POST" action="{{route('login')}}"> <!-- once the form is submitted by the user it is sent to the login route-->
                @csrf {{-- this token is added for security of the form--}}

                <div>
                    <!-- this is where the user will enter the email address-->
                    <label for="email_address">Email address:</label>
                    <input type="email" name="email_address" id="email_address" required>
                </div>

                <div>
                    <!-- this is where the user will enter their password-->
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit">Login</button> <!-- allows the user to login-->

                <p class="signup-message">
                    Don't have an account? <a href="signup">Sign up</a> <!-- redirects the user to signup to make an account-->
                </p>


            </form>

        </section>

    </body>

   <!-- creating the footer-->
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
</html>