<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Shared Admin CSS -->
  <link rel="stylesheet" href="TP2_Admin_Common.css">
  <link rel="stylesheet" href="TP2_Admin_Orders.css">
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
                <p class="profile-name">Full Name</p>
                <p class="profile-role">Admin</p>
            </div>
        </div>
        
        <a class="sidebar-logout" href="TP2_Home.html">LOGOUT</a>
        
        <!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
        <nav class="admin-nav">
            <a href="TP2_Admin_Dashboard.html">
                <span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
                <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
            </a>

            <a class="active" href="TP2_Admin_Orders.html">
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

            <a href="TP2_Admin_Settings.html">
                <span class="nav-text">Admin Settings</span>
                <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
            </a>
        </nav>
    </aside>
    
    <!--PAGE CONTENT (THIS PART CHANGES)-->
    <!-- PAGE CONTENT GOES HERE -->
     <section class="admin-content">
        <div class="admin-content-inner">
            
        <!-- PAGE TITLE -->
         <div class="dash-title orders-title">
            <p class="dash-kicker">Hello Admin</p>
            <h1>Orders</h1>
        </div>