<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Reset Your Password</title>
        <link rel="stylesheet" href="{{asset('loginstyle.css')}}"> <!-- added a link to the stylesheet-->
        <link rel="stylesheet" href="{{asset('common-style.css')}}">
        <!-- Google font-->
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

                <!--main nav bar-->
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
            <h2>Create Your New Password</h2>
            <p class="welcome-sub-message">Please enter your new password below.</p>

            {{-- This will display error messages to the user--}}
            @if (!empty($error_messages))
                <ul class="error-messages">
                    @foreach ($error_messages as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            {{-- this is where the password will get updated--}}
            <form method="POST" action="{{route('password.update')}}">
                @csrf
                <input type="hidden" name="token" value="{{$token}}"> {{-- added a hidden token to ensure it is a valid reset request--}}

                <div>
                     {{-- showing the user email as readonly to keep integrity--}}
                    <label for="email">Email Address:</label>
                    <input type="email" name="email" id="email" value="{{$email}}" required readonly>
                </div>

                <div>
                    {{-- the user will enter their new password here--}}
                    <label for="password">New Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div>
                    {{-- the user will confirm their password here--}}
                    <label for="password_confirmation">Confirm New Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit">Update Password</button>
            </form>
        </section>

        <footer class="site-footer">
            <div class="footer-bottom">
                &copy; 2025 Tecci. All rights reserved.
            </div>
        </footer>

    </body>

</html>
