<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<title>Tecci | Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('common-style.css') }}">
<link rel="stylesheet" href="{{ asset('admin-orders-styles.css') }}">
<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
  <div class="container nav-container">
    <!--The Logo and Menu Button are now grouped together on the left-->
    <div class="header-left-group">
      <!--Logo-->
      <a href="/" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
      </a>
      
      <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
        <!--id="menuBtn" connects to the JS, for it to work-->
        <i class="fa-solid fa-bars"></i> <!--fa-bars is a Menu Icon linked from Font Awesome-->
      </button>
    </div>
    
    <div class="admin-header-spacer"></div>

    <!--Icons-->
    <div class="nav-icons admin-top-icons">
      <a href="TP2_Notifications.html" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>  <!--fa-bell is a Bell Icon linked from Font Awesome-->
      <a href="TP2_Messages.html" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>  <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
      <a href="/" aria-label="Home"><i class="fa-solid fa-house"></i></a>  <!--fa-house is a House Icon linked from Font Awesome-->
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

    <a class="sidebar-logout" href="/">LOGOUT</a>

    <!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
    <nav class="admin-nav">
      <a href="/admin-dashboard">
        <span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
        <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
      </a>

      <a class="active" href="/admin-orders">
        <span class="nav-text">Orders</span>
        <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span> <!--fa-receipt is a Receipt Icon linked from Font Awesome-->
      </a>

      <a href="/admin-inventory">
        <span class="nav-text">Inventory</span>
        <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span> <!--fa-warehouse is a Warehouse Icon linked from Font Awesome-->
      </a>

      <a href="/admin-customers">
        <span class="nav-text">Customers</span>
        <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span> <!--fa-user-group is a User (Group) Icon linked from Font Awesome-->
      </a>

      <a href="/admin-settings">
        <span class="nav-text">Admin Settings</span>
        <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
      </a>
    </nav>
  </aside>


<section class="admin-content">
    <div class="admin-content-inner">
        <a href="{{ route('admin.orders.index') }}" style="text-decoration: none; color: #666;">
            <i class="fa-solid fa-arrow-left"></i> Back to All Orders
        </a>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <h1>Order #{{ $order->id }} Details</h1>
            <span class="status-pill status-{{ strtolower($order->status) }}" style="padding: 10px 20px; border-radius: 50px; font-weight: bold;">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #eee;">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Date Placed:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>

        <h3 style="margin-top: 30px;">Items in this Order</h3>
        <table class="orders-table" style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 15px;">Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Return Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; display: flex; align-items: center;">
                        <img src="{{ asset($item->image_url) }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px; border-radius: 4px;">
                        {{ $item->product_name }}
                    </td>
                    <td>£{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>£{{ number_format($item->price * $item->quantity, 2) }}</td>
                    <td>
                        @if($item->return_status && $item->return_status !== 'none')
                            <span style="color: #e67e22; font-weight: bold;">{{ $item->return_status }}</span>
                        @else
                            <span style="color: #999;">No Return</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px;">
            <h2>Total: £{{ number_format($order->total_price, 2) }}</h2>
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
              <li><a href="/">Home</a></li>
              <li><a href="/about-us">About</a></li>
              <li><a href="/contact-us">Contact</a></li>
              <li><a href="/displayproduct">Products</a></li>
              <li><a href="/basket">Basket</a></li>
              <li><a href="/account">My Account</a></li>
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

<!--Link to external JavaScript File-->
<script src="TP2_Admin_Dashboard.js"></script>
</body>
</html>