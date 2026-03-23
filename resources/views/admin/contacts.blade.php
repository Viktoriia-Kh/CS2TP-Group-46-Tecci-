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
        <a href="/admin-dashboard">Dashboard</a>
        <a href="/admin-orders">Orders</a>
        <a href="/admin-inventory">Inventory</a>
        <a href="/admin/customers">Customers</a>
        <a class="active" href="{{ route('admin.contacts') }}">Contact Messages</a>
        <a href="/admin-settings">Admin Settings</a>
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
    <div class="container footer-inner">
      <div class="footer-col">
        <h3>TECCI</h3>
        <p>Smart Tech at Smart Prices.</p>
      </div>
    </div>
  </footer>

</body>
</html>