<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Shared Admin CSS -->
  <link rel="stylesheet" href="{{asset('admin-common-style.css')}}">
  <link rel="stylesheet" href="{{asset('adminsettings.css')}}">
  <link rel="stylesheet" href="{{asset('common-style.css')}}">

  <!--Google Font-->
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
    <div class="container nav-container">

      <!--Logo-->
      <a href="TP2_Home.html" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
      </a>

      <!--ADMIN HEADER CONTROLS (MENU + SEARCH)-->
      <div class="admin-header-controls">
        <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
          <!--id="menuBtn" connects to the JS, for it to work-->
          <i class="fa-solid fa-bars"></i> <!--fa-bars is a Menu Icon linked from Font Awesome-->
        </button>

        <div class="search-wrap"> <!--This is a wrapper for styling purpose of the Search Bar-->
          <!--fa-magnifying-glass is a Magnifying Glass Icon linked from Font Awesome-->
          <i class="fa-solid fa-magnifying-glass"></i> <!--This creates a Magnifying Glass Icon which is just purely visual for now-->
          <input type="text" placeholder="Search" aria-label="Search (visual only)">
        </div>
      </div>

      <!--Icons-->
      <div class="nav-icons admin-top-icons">
        <a href="TP2_Notifications.html" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>  <!--fa-bell is a Bell Icon linked from Font Awesome-->
        <a href="TP2_Messages.html" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>  <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
        <a href="TP2_Home.html" aria-label="Home"><i class="fa-solid fa-house"></i></a>  <!--fa-house is a House Icon linked from Font Awesome-->
      </div>

    </div>
  </header>

  <!--MAIN ADMIN LAYOUT-->
  <main class="admin-shell"> <!--This is a layout wrapper which contains the Sidebar and Content Area-->
    <!--SIDEBAR-->
    <aside class="admin-sidebar" id="adminSidebar"> <!--aside represents the secondary content, side navigation-->
      <div class="admin-profile">
        <div class="profile-avatar">
          <i class="fa-solid fa-user-tie"></i>  <!--fa-user-tie is a User/Avatar Icon linked from Font Awesome-->
        </div>
        <div class="profile-meta"> <!--Using this will allow the Avatar/Profile to stay visible while hiding the text, which is all done in CSS-->
          <p class="profile-name">{{Auth::user()->name}}</p> {{-- the user will see their full name on the side--}}
          <p class="profile-role">Admin</p>
        </div>
      </div>

      {{-- logout button--}}
            <form action="{{ route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">Logout</button>
            </form>

      <!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
      <nav class="admin-nav">
        <a href="TP2_Admin_Dashboard.html">
          <span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
          <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
        </a>

        <a href="TP2_Admin_Orders.html">
          <span class="nav-text">Orders</span>
          <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span> <!--fa-receipt is a Receipt Icon linked from Font Awesome-->
        </a>

        <a href="TP2_Admin_Products.html">
          <span class="nav-text">Products</span>
          <span class="nav-ico"><i class="fa-solid fa-box"></i></span> <!--fa-vox is a Box Icon linked from Font Awesome-->
        </a>

        <a href="TP2_Admin_Inventory.html">
          <span class="nav-text">Inventory</span>
          <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span> <!--fa-warehouse is a Warehouse Icon linked from Font Awesome-->
        </a>

        <a href="TP2_Admin_Customers.html">
          <span class="nav-text">Customers</span>
          <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span> <!--fa-user-group is a User (Group) Icon linked from Font Awesome-->
        </a>

        <a class="active" href="admin-settings">
          <span class="nav-text">Admin Settings</span>
          <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
        </a>
      </nav>
    </aside>

    <!--PAGE CONTENT (THIS PART CHANGES)-->

    <section class="admin-content">
    <div class="admin-content-inner">

    <!-- PAGE TITLE -->
     <div class="dash-title">
        <p class="dash-kicker">Admin Section</p>
        <h1>Admin Settings</h1>
    </div>

    <!-- PAGE CONTENT GOES HERE -->
    <div class="account-container">
        <section class="account-header">
            <h2>Admin Profile</h2>
            <p>Update your admin details below.</p>
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
                <form method="POST" action="{{ route('admin.settings.update')}}">
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

            {{--the user will be able to delete their account here--}}
            <form id="delete-form" action="{{ route('admin.settings.delete')}}" method="POST">
                @csrf
                @method('DELETE') {{-- allows the user to delete their account--}}
                <button type="button" class="delete-button" onclick="confirmAccountDeletion()">Delete Account</button>
            </form>
        </div>
   </div>



    </div>

</div>
</section>

</main>

<!--FOOTER (REUSABLE)-->
<footer class="site-footer">
    <div class="container footer-inner"> <!--footer-inner used to create multi-column layout-->
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
                <li><a href="TP2_Home.html">Home</a></li>
                <li><a href="TP2_About.html">About</a></li>
                <li><a href="TP2_Contact.html">Contact</a></li>
                <li><a href="products.html">Products</a></li>
                <li><a href="basket.html">Basket</a></li>
                <li><a href="account.html">My Account</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="contact-list">
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    <!--fa-loocation-dot is a Location Icon linked from Font Awesome-->
                    <span>0121 555 0198</span><br><br>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
                    <span>Tecci_Queries@net.com</span><br><br>
                </li>
                <li>
                    <i class="fa-regular fa-envelope"></i>
                    <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
                    <span>Birmingham, B4 7ET</span><br><br>
                </li>
            </ul>
        </div>
    </div> <!--Closes <div class="container footer-inner"-->
    <div class="footer-bottom">
        <p>&copy; 2025 Tecci. All rights reserved.</p>
    </div>
</footer>

{{-- javascript to handle the account deletion--}}
<script>
    function confirmAccountDeletion() {
        if(confirm('Are you sure you want to delete your Tecci Admin account?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>

<!--Link to external JavaScript File-->

<script src="{{asset('admin-dashboard.js')}}"></script>
</body>
</html>
