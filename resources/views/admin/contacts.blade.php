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

        <a href="/admin-dashboard" class="menu-btn">
          <i class="fa-solid fa-bars"></i>
        </a>
      </div>

      <div class="admin-header-spacer"></div>

      <div class="nav-icons admin-top-icons">
        <a href="/admin-dashboard"><i class="fa-regular fa-bell"></i></a>
        <a href="/admin/contacts"><i class="fa-regular fa-envelope"></i></a>
        <a href="/"><i class="fa-solid fa-house"></i></a>
      </div>
    </div>
  </header>

  <main class="admin-shell">
    <aside class="admin-sidebar">

      <div class="admin-profile">
        <div class="profile-avatar">
          <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="profile-meta">
          <p class="profile-name">{{Auth::user()->name}}</p>
          <p class="profile-role">Admin</p>
        </div>
      </div>

      <a class="sidebar-logout" href="/">LOGOUT</a>

      <nav class="admin-nav">
        <a  href="/admin-dashboard">
          <span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
          <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
        </a>

        <a href="/admin-orders">
          <span class="nav-text">Orders</span>
          <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span> <!--fa-receipt is a Receipt Icon linked from Font Awesome-->
        </a>



        <a  href="/admin-inventory">
          <span class="nav-text">Inventory</span>
          <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span> <!--fa-warehouse is a Warehouse Icon linked from Font Awesome-->
        </a>

        <a href="/admin/customers">
          <span class="nav-text">Customers</span>
          <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span> <!--fa-user-group is a User (Group) Icon linked from Font Awesome-->
        </a>

        <a class="active" href="{{ route('admin.contacts') }}">
          <span class="nav-text">Contact Messages</span>
          <span class="nav-ico"><i class="fa-solid fa-envelope"></i></span>
        </a>

        <a href="/admin-settings">
          <span class="nav-text">Admin Settings</span>
          <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
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

            @if(session('success'))
              <p style="color: green; margin-bottom: 15px;">
                {{ session('success') }}
              </p>
            @endif

            @if($contacts->isEmpty())
              <p style="padding: 20px;">No contact messages found.</p>
            @else

            <table class="dash-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Issue</th>
                  <th>Status</th>
                  <th>Reply</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                @foreach($contacts as $contact)
                <tr>
                  <td>{{ $contact->id }}</td>
                  <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                  <td>{{ $contact->phone }}</td>
                  <td>{{ $contact->email }}</td>
                  <td>{{ $contact->issue }}</td>
                  <td>{{ ucfirst($contact->status) }}</td>

                  <!-- Reply column -->
                  <td>
                    @if($contact->admin_reply)

                      <div class="reply-text">
                        {{ $contact->admin_reply }}
                        <br>
                        <small class="reply-date">
                          Replied: {{ $contact->replied_at ? $contact->replied_at->format('d M Y H:i') : '' }}
                        </small>
                      </div>

                    @else

                      <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST" class="reply-form">
                        @csrf

                        <textarea 
                          name="admin_reply" 
                          rows="3" 
                          placeholder="Write reply..." 
                          class="reply-box"
                        ></textarea>

                        <button type="submit" class="btn btn-primary btn-sm">
                          Save Reply
                        </button>

                      </form>

                    @endif
                  </td>

                  <!-- Actions column -->
                  <td>
                    @if($contact->status !== 'resolved')

                      <form action="{{ route('admin.contacts.resolve', $contact->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-success btn-sm">
                          Mark Resolved
                        </button>

                      </form>

                    @else

                      <span class="status-resolved">Resolved</span>

                    @endif
                  </td>

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

</body>
</html>