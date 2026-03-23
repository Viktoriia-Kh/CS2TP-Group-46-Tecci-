<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<title>Tecci | Orders Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- Updated CSS File -->
<link rel="stylesheet" href="{{ asset('admin-orders-styles.css') }}">
<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
<!--Font Awesome for Icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
  <div class="container nav-container">
    <div class="header-left-group">
      <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>

      <a href="/admin-dashboard" class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
        <i class="fa-solid fa-bars"></i>
      </a>
    </div>

    <div class="admin-header-spacer"></div>

    <div class="nav-icons admin-top-icons">
      <a href="/admin-dashboard" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>
      <a href="/admin/contacts" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>
      <a href="/" aria-label="Home"><i class="fa-solid fa-house"></i></a>
    </div>
  </div>
</header>

<!--MAIN ADMIN LAYOUT-->
<main class="admin-shell">
  <!--SIDEBAR-->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-profile">
      <div class="profile-avatar">
        <i class="fa-solid fa-user-tie"></i>
      </div>
      <div class="profile-meta">
        <p class="profile-name">{{ Auth::user()->name }}</p>
        <p class="profile-role">Admin</p>
      </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>

    <a class="sidebar-logout" href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       LOGOUT
    </a>

    <nav class="admin-nav">
      <a href="/admin-dashboard">
        <span class="nav-text">Dashboard</span>
        <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span>
      </a>

      <a class="active" href="/admin-orders">
        <span class="nav-text">Orders</span>
        <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span>
      </a>

      <a href="/admin-inventory">
        <span class="nav-text">Inventory</span>
        <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span>
      </a>

      <a href="/admin/customers">
        <span class="nav-text">Customers</span>
        <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span>
      </a>

      <a href="{{ route('admin.contacts') }}">
        <span class="nav-text">Contact Messages</span>
        <span class="nav-ico"><i class="fa-solid fa-envelope"></i></span>
      </a>

      <a href="/admin-settings">
        <span class="nav-text">Admin Settings</span>
        <span class="nav-ico"><i class="fa-solid fa-gear"></i></span>
      </a>
    </nav>
  </aside>

  <!--PAGE CONTENT-->
  <section class="admin-content">
    <div class="admin-content-inner">

      <!-- PAGE TITLE WITH ACTION BUTTON -->
      <div class="dash-title orders-title">
        <div>
          <p class="dash-kicker">Hello Admin</p>
          <h1>Orders</h1>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="btn-initiate-order">
          <i class="fa-solid fa-plus"></i>
          Initiate New Order
        </a>
      </div>

      <!-- SEARCH BAR -->
      <div class="orders-search-row">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="page-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" 
                 name="search" 
                 placeholder="Search by Order ID or Customer Name..." 
                 value="{{ request('search') }}"
                 aria-label="Search orders">
          <button type="submit" style="display:none;"></button>
        </form>
      </div>

      <!-- FILTERS BAR -->
      <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-filter-bar">
        <div class="orders-filter-left">
          <!-- Status Filter -->
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

          <!-- Price Filter -->
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

        <!-- Sort Control -->
        <div class="orders-filter-right">
          <div class="filter-select-wrap sort-select">
            <select name="sort" onchange="this.form.submit()" aria-label="Sort orders">
              <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Sort by Date (Newest)</option>
              <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Sort by Date (Oldest)</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Sort by Price (Low-High)</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Sort by Price (High-Low)</option>
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
                  <td class="checkbox-col">
                    <input type="checkbox" aria-label="Select order {{ $order->id }}">
                  </td>
                  
                  <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="order-number-link">
                      #{{ $order->id }}
                    </a>
                  </td>
                  
                  <td>{{ $order->user->name ?? 'Guest' }}</td>
                  
                  <td>
                    <!-- Status Dropdown with Auto-submit -->
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" 
                          method="POST" 
                          style="display:inline-block;">
                      @csrf
                      @method('PUT')
                      <select name="status" 
                              onchange="this.form.submit()"
                              class="status-pill status-{{ strtolower($order->status) }}"
                              aria-label="Change order status">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $order->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                      </select>
                    </form>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="view-details-link">
                      View Details
                    </a>
                  </td>
                  
                  <td>£{{ number_format($order->total_price, 2) }}</td>
                  
                  <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="empty-state">
                      <i class="fa-solid fa-inbox"></i>
                      <p>No orders found matching those filters.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <!-- PAGINATION -->
          @if($orders->hasPages())
            <div class="pagination-wrap">
              {{ $orders->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
      </section>

    </div>
  </section>
</main>

<!--FOOTER-->
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
        <li><a href="/account">My Account</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul class="contact-list">
        <li>
          <i class="fa-solid fa-location-dot"></i>
          <span>Birmingham, B4 7ET</span>
        </li>
        <li>
          <i class="fa-solid fa-phone"></i>
          <span>0121 555 0198</span>
        </li>
        <li>
          <i class="fa-regular fa-envelope"></i>
          <span>Tecci_Queries@net.com</span>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="footer-bottom">
    <p>&copy; 2025 Tecci. All rights reserved.</p>
  </div>
</footer>

<!--JavaScript for Sidebar Toggle-->
<script src="{{ asset('TP2_Admin_Dashboard.js') }}"></script>

</body>
</html>
