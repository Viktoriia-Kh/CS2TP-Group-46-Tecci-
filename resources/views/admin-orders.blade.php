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

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
    <div class="container nav-container">
      <!--The Logo and Menu Button are now grouped together on the left-->
      <div class="header-left-group">
        <!--Logo-->
        <a href="TP2_Home.html" class="logo">
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

        <!--The Search Bar has been moved uner the page heading-->  
        <div class="orders-search-row"> <!--This is a wrapper for styling purpose of the Search Bar-->
          <div class="page-search-wrap">
          <!--fa-magnifying-glass is a Magnifying Glass Icon linked from Font Awesome-->
          <i class="fa-solid fa-magnifying-glass"></i> <!--This creates a Magnifying Glass Icon which is just purely visual for now-->
          <input type="text" placeholder="Search" aria-label="Search (visual only)">
        </div>
      </div>


        <!-- FILTER BAR -->
        <div class="orders-filter-bar">
          <div class="orders-filter-left">
            <div class="filter-select-wrap">
              <select aria-label="Filter by order status">
                <option selected>Any Status</option>
                <option>Paid</option>
                <option>Delivered</option>
                <option>Completed</option>
              </select>
              <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="filter-select-wrap">
              <select aria-label="Filter by price range">
                <option selected>£0 - £100</option>
                <option>£100 - £500</option>
                <option>£500 - £1000</option>
                <option>£1000 - £1500</option>
                <option>£1500+</option>
              </select>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>

          <div class="orders-filter-right">
            <div class="filter-select-wrap sort-select">
              <select aria-label="Sort orders">
                <option selected>Sort by Date</option>
                <option>Sort by Price</option>
              </select>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>
        </div>

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
                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Ramsha Ahmed"></td>
                  <td>#2049</td>
                  <td>Ramsha Ahmed</td>
                  <td><span class="status-pill status-paid">PAID</span></td>
                  <td>£950.99</td>
                  <td>Jan 8</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Manrohit Bahia"></td>
                  <td>#2049</td>
                  <td>Manrohit Bahia</td>
                  <td><span class="status-pill status-delivered">DELIVERED</span></td>
                  <td>£350.99</td>
                  <td>Jan 6</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Jayden Dunkley Singh"></td>
                  <td>#2049</td>
                  <td>Jayden Dunkley Singh</td>
                  <td><span class="status-pill status-paid">PAID</span></td>
                  <td>£499.99</td>
                  <td>Jan 5</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Muhammad Ibrahim"></td>
                  <td>#2049</td>
                  <td>Muhammad Ibrahim</td>
                  <td><span class="status-pill status-paid">PAID</span></td>
                  <td>£599.99</td>
                  <td>Jan 2</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" checked aria-label="Select order 2049 Viktoriia Kharchenko"></td>
                  <td>#2049</td>
                  <td>Viktoriia Kharchenko</td>
                  <td><span class="status-pill status-completed">COMPLETED</span></td>
                  <td>£799.99</td>
                  <td>Dec 28</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Ryan Njualem"></td>
                  <td>#2049</td>
                  <td>Ryan Njualem</td>
                  <td><span class="status-pill status-paid">PAID</span></td>
                  <td>£299.99</td>
                  <td>Dec 26</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Kirpal Sangha"></td>
                  <td>#2049</td>
                  <td>Kirpal Sangha</td>
                  <td><span class="status-pill status-delivered">DELIVERED</span></td>
                  <td>£750.99</td>
                  <td>Dec 22</td>
                </tr>

                <tr>
                  <td class="checkbox-col"><input type="checkbox" aria-label="Select order 2049 Musa Abid Waheed"></td>
                  <td>#2049</td>
                  <td>Musa Abid Waheed</td>
                  <td><span class="status-pill status-completed">COMPLETED</span></td>
                  <td>£650.99</td>
                  <td>Dec 19</td>
                </tr>
              </tbody>
            </table>
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

<!--Link to external JavaScript File-->
<script src="TP2_Admin_Dashboard.js"></script>
</body>
</html>