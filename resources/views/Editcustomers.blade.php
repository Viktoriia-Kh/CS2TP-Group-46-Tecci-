<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tecci | Edit Customer</title>

  <link rel="stylesheet" href="{{ asset('admin-common-style.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <header class="main-header">
    <div class="container nav-container">
      <div class="header-left-group">
        <a href="/" class="logo">
          <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
          <span class="logo-text">TECCI</span>
        </a>

        <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>

      <div class="admin-header-spacer"></div>

      <div class="nav-icons admin-top-icons">
        <a href="/admin-dashboard" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>
        <a href="/admin/contacts" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>
        <a href="/" aria-label="Home"><i class="fa-solid fa-house"></i></a>
      </div>
    </div>
  </header>

  <main class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="admin-profile">
        <div class="profile-avatar">
          <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="profile-meta">
          <p class="profile-name">Full Name</p>
          <p class="profile-role">Admin</p>
        </div>
      </div>

      <a class="sidebar-logout" href="/">LOGOUT</a>

      <nav class="admin-nav">
        <a href="/admin-dashboard">
          <span class="nav-text">Dashboard</span>
          <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span>
        </a>

        <a href="/admin-orders">
          <span class="nav-text">Orders</span>
          <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span>
        </a>

        <a href="/admin-inventory">
          <span class="nav-text">Inventory</span>
          <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span>
        </a>

        <a class="active" href="{{ route('admin.customers') }}">
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

    <section class="admin-content">
      <div class="admin-content-inner">
        <div class="dash-title">
          <p class="dash-kicker">Admin Panel</p>
          <h1>Edit Customer</h1>
        </div>

        <div class="panel table-panel">
          <div class="panel-header">
            <h2>Update Customer Details</h2>
          </div>

          @if($errors->any())
            <div style="margin-bottom: 16px; color: #b91c1c; font-weight: 700;">
              @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom:6px; font-weight:700;">Name</label>
              <input
                type="text"
                name="name"
                value="{{ old('name', $customer->name) }}"
                required
                style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
              >
            </div>

            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom:6px; font-weight:700;">Email</label>
              <input
                type="email"
                name="email"
                value="{{ old('email', $customer->email) }}"
                required
                style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
              >
            </div>

            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom:6px; font-weight:700;">Phone</label>
              <input
                type="text"
                name="phone"
                value="{{ old('phone', $customer->phone) }}"
                style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
              >
            </div>

            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom:6px; font-weight:700;">Address</label>
              <input
                type="text"
                name="address"
                value="{{ old('address', $customer->address) }}"
                style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
              >
            </div>

            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom:6px; font-weight:700;">New Password (optional)</label>
              <input
                type="password"
                name="password"
                style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;"
              >
            </div>

            <div style="display:flex; gap:12px; margin-top:20px;">
              <button
                type="submit"
                style="padding:10px 16px; background:#03315b; color:white; border:none; border-radius:8px; cursor:pointer;"
              >
                Update Customer
              </button>

              <a
                href="{{ route('admin.customers') }}"
                style="padding:10px 16px; background:#6b7280; color:white; border-radius:8px; text-decoration:none;"
              >
                Back
              </a>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

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
          <li><i class="fa-solid fa-location-dot"></i><span>0121 555 0198</span></li>
          <li><i class="fa-solid fa-phone"></i><span>Tecci_Queries@net.com</span></li>
          <li><i class="fa-regular fa-envelope"></i><span>Birmingham, B4 7ET</span></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Tecci. All rights reserved.</p>
    </div>
  </footer>

  <script src="{{ asset('TP2_Admin_Dashboard.js') }}"></script>
</body>
</html>
