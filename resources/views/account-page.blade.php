<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Tecci Account</title>
        <link rel="stylesheet" href="accountstyle.css"> <!-- created a link to the stylesheet-->
        <link rel="stylesheet" href="common-style.css">
        <link rel="stylesheet" href="{{ asset('Dark-Mode.css')}}">
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

                <!-- main nav bar-->
                <nav class="main-nav">
                    <ul>
                        <li><a href="{{ url('/')}}">Home</a></li>
                        <li><a href="about-us">About</a></li>
                        <li><a href="contact-us">Contact</a></li>
                        <li><a href="displayproduct">Products</a></li>
                    </ul>
                </nav>

                <!-- icons on the nav bar-->
                <div class="nav-icons">
                    <a href="/my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
                    <a href="{{ url('basket')}}"><i class="fa-solid fa-cart-shopping"></i></a>

                     @if(Auth::check())
                        {{-- If logged in, check if they are an admin --}}
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : url('account') }}">
                                <i class="fa-regular fa-user"></i>
                            </a>
                    @else
                        {{-- If not logged in, just go to the login page --}}
                            <a href="{{ url('login') }}">
                                <i class="fa-regular fa-user"></i>
                            </a>
                    @endif

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

        <div class="account-container">
            <section class="account-header">
                <h2>My Tecci Account</h2>
                <p>Manage your personal information.</p>
            </section>

            {{-- adding a success message for the user--}}
            @if (session('success'))
                <div class="success-messages">
                    {{session('success')}}
                </div>
            @endif

            {{-- adding error messages--}}
            @if ($errors->any())
                <ul class="error-messages">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <div class="section-form">
                {{-- user can update and view their information here--}}
                <form method="POST" action="{{ route('account.update')}}">
                    @csrf {{-- added this token for the security of the form--}}
                    @method('PATCH') {{-- allows the user to make the partial changes--}}

                    <!-- this is where the user will enter their full name-->
                    <label for="name">Full Name:</label>
                    <input type="text" name="name" id="name" value="{{ $user->name}}" required>

                    <!-- this is where the user will enter the email address-->
                    <label for="email">Email Address:</label>
                    <input type="email" name="email_address" id="email_address" value="{{ $user->email}}" required>

                    <!-- this is where the user can add a phone number if they wish-->
                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" value="{{ $user->phone}}" placeholder="Enter your phone number">

                    <button type="submit">Update Information</button>
                </form>

            <hr class="divide-form"> {{-- organises the form--}}

            {{-- logout button--}}
            <form action="{{ route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>

            {{--the user will be able to delete their account here--}}
            <form id="delete-form" action="{{ route('account.destroy')}}" method="POST">
                @csrf
                @method('DELETE') {{-- allows the user to delete their account--}}
                <button type="button" class="delete-button" onclick="confirmAccountDeletion()">Delete Account</button>
            </form>
        </div>
   </div>



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
{{-- javascript to handle the account deletion--}}
        <script>
            function confirmAccountDeletion() {
                if(confirm('Are you sure you want to delete your Tecci account?')) {
                    document.getElementById('delete-form').submit();
                }
            }
        </script>
    </body>
</html>

<script src="Dark-Mode-Theme.js"></script>
