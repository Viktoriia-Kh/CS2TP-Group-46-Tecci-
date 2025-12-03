<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="UTF-8">
       <title>Basket</title>
       <link rel="stylesheet" href="{{asset('style.css') }}"> <!-- created a link to the stylesheet-->
       <!-- Google font -->
       <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
   </head>
   <body>
   <!-- adding simple nav bar to the login page-->
   <nav class="login-navbar">
       <div class="navbar-left">
           <!-- logo will be on the left side of the navbar-->
           <img src="{{asset('images/Logo.png')}}" class="tecci-logo" alt="Tecci Logo"> <!-- linked the image file-->
           <span class="tecci-text">Tecci</span>
       </div>


       <div class="navbar-right">
           <a href="/homepage" class="homepage-link">Return To Home</a>
       </div>
   </nav>
       


   </body>


   <!-- creating a simple footer -->
   <footer class="basic-footer">
       <p>&copy; 2025 Tecci. All rights reserved.</p>
   </footer>


</html>