<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Tecci Account</title>
        <link rel="stylesheet" href="loginstyle.css"> <!-- created a link to the stylesheet-->
        <link rel="stylesheet" href="common-style.css">
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
            </div>
        </header>
    </body>
</html>
