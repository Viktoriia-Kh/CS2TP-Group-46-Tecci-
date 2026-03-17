<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Contact Messages</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="{{ asset('adminstyles.css') }}" />
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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
        <a href="#" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>
        <a href="#" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>
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

        <a href="/admin-customers">
          <span class="nav-text">Customers</span>
          <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span>
        </a>

        <a class="active" href="{{ route('admin.contacts') }}">
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
          <h1>Contact Messages</h1>
        </div>

        <div class="panel table-panel">
          <div class="panel-header">
            <h2>Submitted Contact Forms</h2>
          </div>

          <div class="table-wrap">
            @if($contacts->isEmpty())
              <p style="padding: 20px;">No contact messages found.</p>
            @else
              <table class="dash-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Issue</th>
                    <th>Submitted At</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($contacts as $contact)
                    <tr>
                      <td>{{ $contact->id }}</td>
                      <td>{{ $contact->first_name }}</td>
                      <td>{{ $contact->last_name }}</td>
                      <td>{{ $contact->phone }}</td>
                      <td>{{ $contact->email }}</td>
                      <td>{{ $contact->issue }}</td>
                      <td>{{ $contact->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
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
          <li>
            <i class="fa-solid fa-location-dot"></i>
            <span>0121 555 0198</span><br><br>
          </li>
          <li>
            <i class="fa-solid fa-phone"></i>
            <span>Tecci_Queries@net.com</span><br><br>
          </li>
          <li>
            <i class="fa-regular fa-envelope"></i>
            <span>Birmingham, B4 7ET</span><br><br>
          </li>
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