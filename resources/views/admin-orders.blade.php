<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<title>Tecci | Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- Shared Admin CSS -->
<link rel="stylesheet" href="TP2_Admin_Common.css">
<link rel="stylesheet" href="admin-orders-styles.css">
<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
<!--Font Awesome for Icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>


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

<!--PAGE CONTENT (THIS PART CHANGES)-->
<!-- PAGE CONTENT GOES HERE -->
<section class="admin-content">
    <div class="admin-content-inner">

      <!-- PAGE TITLE -->
      <div class="dash-title orders-title">
        <p class="dash-kicker">Hello Admin</p>
        <h1>Orders</h1>
      </div>

      <!-- SEARCH BAR (CONNECTED) -->
<div class="orders-search-row">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="page-search-wrap">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" name="search" placeholder="Search ID or Customer..." value="{{ request('search') }}">
      <button type="submit" style="display:none;"></button> <!-- Hidden button allows 'Enter' to search -->
    </form>
</div>


      <!-- FILTER BAR (FIXED: KEEPS THE SORT BUTTON ON THE RIGHT) -->
<form action="{{ route('admin.orders.index') }}" method="GET" class="orders-filter-bar">
<div class="orders-filter-left">
  <div class="filter-select-wrap">
    <select name="status_filter" onchange="this.form.submit()" aria-label="Filter by order status">
      <option value="">Any Status</option>
      <option value="Pending" {{ request('status_filter') == 'Pending' ? 'selected' : '' }}>Pending</option>
      <option value="Approved" {{ request('status_filter') == 'Approved' ? 'selected' : '' }}>Approved</option>
      <option value="Shipped" {{ request('status_filter') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
      <option value="Completed" {{ request('status_filter') == 'Completed' ? 'selected' : '' }}>Completed</option>
      <option value="Cancelled" {{ request('status_filter') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <i class="fa-solid fa-chevron-down"></i>
  </div>

  <div class="filter-select-wrap">
    <select name="price_filter" onchange="this.form.submit()" aria-label="Filter by price range">
      <option value="">All Prices</option>
      <option value="0-100" {{ request('price_filter') == '0-100' ? 'selected' : '' }}>£0 - £100</option>
      <option value="100-500" {{ request('price_filter') == '100-500' ? 'selected' : '' }}>£100 - £500</option>
      <option value="500-1000" {{ request('price_filter') == '500-1000' ? 'selected' : '' }}>£500 - £1000</option>
      <option value="1000+" {{ request('price_filter') == '1000+' ? 'selected' : '' }}>£1000+</option>
    </select>
    <i class="fa-solid fa-chevron-down"></i>
  </div>
</div>

<div class="orders-filter-right">
  <div class="filter-select-wrap sort-select">
    <select name="sort" onchange="this.form.submit()" aria-label="Sort orders">
      <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Sort by Date</option>
      <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Sort by Price</option>
    </select>
    <i class="fa-solid fa-chevron-down"></i>
  </div>
</div>
</form>

      <!-- ORDERS TABLE PANEL -->
      <section class="orders-panel">
        <div class="orders-table-wrap">
          <table class="orders-table">
            <thead>
              <tr>
                <th class="checkbox-col"></th>
                <th>Order</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Price</th>
                <th>Date</th>
              </tr>
            </thead>

            <tbody>
    @forelse($orders as $order)
      <tr>
        <td class="checkbox-col"><input type="checkbox"></td>
          <td>
            <a href="{{ route('admin.orders.show', $order->id) }}" style="color: #03315b; font-weight: bold; text-decoration: underline;">
      #{{ $order->id }}
  </a>
</td>
        <td>{{ $order->user->name ?? 'Guest' }}</td>
        <td>
          <!-- This form lets you change status and deduct stock automatically -->
          <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="status" onchange="this.form.submit()" 
                    style="border:none; background:transparent; font-weight:bold; cursor:pointer;"
                    class="status-pill status-{{ strtolower($order->status) }}">
              <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>PENDING</option>
              <option value="Approved" {{ $order->status == 'Approved' ? 'selected' : '' }}>APPROVED</option>
              <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>SHIPPED</option>
              <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>COMPLETED</option>
              <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>CANCELLED</option>
            </select>
          </form>
        </td>
        <td>£{{ number_format($order->total_price, 2) }}</td>
        <td>{{ $order->created_at->format('M d') }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6" style="text-align:center; padding: 40px; color: #666;">No orders found matching those filters.</td>
      </tr>
    @endforelse
  </tbody>
          </table>
        <div class="pagination-wrap" style="padding: 20px;">
        {{ $orders->appends(request()->query())->links() }}
        </div>

        </div>
      </section>

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