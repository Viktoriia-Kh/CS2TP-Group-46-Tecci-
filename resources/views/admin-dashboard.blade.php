<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8" />
    <title>Tecci | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Links to HTML/CSS Files-->
    <link rel="stylesheet" href="adminstyles.css" />
    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
    <!--Font Awesome for Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body>
    <header class="main-header">
        <div class="container nav-container">
            <!--Logo-->
            <a href="admin-dashboard.blade.php" class="logo">
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
    
    <!--MAIN DASHBOARD LAYOUT-->
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
            
            <a class="sidebar-logout" href="admin-dashboard.blade.php">LOGOUT</a>
            
            <!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
            <nav class="admin-nav">
                <a class="active" href="TP2_Admin_Dashboard.html">
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

                <a href="TP2_Admin_Reports.html">
                    <span class="nav-text">Reports</span>
                    <span class="nav-ico"><i class="fa-solid fa-file-lines"></i></span> <!--fa-file-lines is a File Icon linked from Font Awesome-->
                </a>

                <a href="TP2_Admin_Settings.html">
                    <span class="nav-text">Admin Settings</span>
                    <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
                </a>
            </nav>
        </aside>
        
        <!--CONTENT-->
        <section class="admin-content">
            <div class="admin-content-inner">
                
            <!--PAGE TITLE-->
            <div class="dash-title">
                <p class="dash-kicker">This Is Your Dashboard</p> <!--class="dash-kicker" is used to separate the small contextual label from large headline-->
                <h1>Hello Admin</h1>
            </div>
            
            <!--TOP GRID: CARDS + ACTIVITY-->
            <div class="dash-top-grid">
                <div class="dash-cards">
                    <article class="metric-card"> <!--article means that the content for this block is conceptually independant-->
                        <p class="metric-label">Sales | Today</p> <!--Using the word metric to represent a value which tracks performance-->
                        <div class="metric-body">
                            <div class="metric-icon">
                                <i class="fa-solid fa-cart-shopping"></i> <!--fa-cart-shopping is a Shopping Cart Icon linked from Font Awesome-->
                            </div>
                            <p class="metric-value">145</p>
                        </div>
                    </article>
                    
                    <article class="metric-card">
                        <p class="metric-label">Revenue | This Month</p>
                        <div class="metric-body">
                            <div class="metric-icon">
                                <i class="fa-solid fa-circle-dollar-to-slot"></i> <!--fa-circle-dollar-to-slot is a Circle Dollar Icon linked from Font Awesome-->
                            </div>
                            <p class="metric-value">£3,264</p>
                        </div>
                    </article>

                    <article class="metric-card metric-wide">
                        <p class="metric-label">Customers | This Year</p>
                        <div class="metric-body">
                            <div class="metric-icon">
                                <i class="fa-solid fa-users"></i> <!--fa-users is a User Icon linked from Font Awesome-->
                            </div>
                            <p class="metric-value">1,244</p>
                        </div>
                    </article>
                </div>
                
                <!--panel is a shared styling class, used so any element with class panel gets a blue background, rounded corners, and padding-->
                <aside class="panel activity-panel"> <!--aside represents the secondary content-->
                    <div class="panel-header">
                        <h2>Recent Activity | Today</h2>
                    </div>
                    
                    <ul class="activity-timeline">
                        <li class="activity-item">
                            <span class="activity-time">32 min</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">Order #2049 was marked as <strong>Approved</strong>.</p>
                        </li>
                        <li class="activity-item">
                            <span class="activity-time">56 min</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">Low stock warning: <strong>Wireless Headphones</strong>.</p>
                        </li>
                        <li class="activity-item">
                            <span class="activity-time">2 hrs</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">New customer account created.</p>
                        </li>
                        <li class="activity-item">
                            <span class="activity-time">1 day</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">Shipment processed for Order #2038.</p>
                        </li>
                        <li class="activity-item">
                            <span class="activity-time">2 days</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">Product updated: <strong>Budget Laptop</strong>.</p>
                        </li>
                        <li class="activity-item">
                            <span class="activity-time">4 weeks</span>
                            <span class="activity-dot"></span>
                            <p class="activity-text">Monthly inventory report generated.</p>
                        </li>
                    </ul>
                </aside>
            </div>
            
            <!--MIDDLE GRID: RECENT SALES + TRAFFIC-->
            <div class="dash-mid-grid"> <!--This is a container for the middle section of the Dashboard-->
                <section class="panel table-panel">
                    <div class="panel-header">
                        <h2>Recent Sales | Today</h2>
                    </div>
                    
                    <div class="table-wrap">
                        <table class="dash-table">
                            <thead> <!--thead defines the header section-->
                                <tr> <!--tr is for the table row-->
                                    <th>#</th> <!--th is for the header cells-->
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody> <!--tbody represents the actual data-->
                                <tr>
                                    <td>#2049</td> <!--td represents the table data cells-->
                                    <td>Ashleigh Langosh</td>
                                    <td>Budget Laptop</td>
                                    <td>£499.99</td>
                                    <td><span class="pill pill-approved">APPROVED</span></td>
                                </tr>
                                <tr>
                                    <td>#2048</td>
                                    <td>Bridie Kessler</td>
                                    <td>Tablet</td>
                                    <td>£399.99</td>
                                    <td><span class="pill pill-pending">PENDING</span></td>
                                </tr>
                                <tr>
                                    <td>#2047</td>
                                    <td>Brandon Jacob</td>
                                    <td>Smartphone</td>
                                    <td>£450.99</td>
                                    <td><span class="pill pill-approved">APPROVED</span></td>
                                </tr>
                                <tr>
                                    <td>#2046</td>
                                    <td>Angus Grady</td>
                                    <td>Accessories Pack</td>
                                    <td>£299.99</td>
                                    <td><span class="pill pill-approved">APPROVED</span></td>
                                </tr>
                                <tr>
                                    <td>#2045</td>
                                    <td>Raheem Lehner</td>
                                    <td>Headphones</td>
                                    <td>£199.99</td>
                                    <td><span class="pill pill-pending">PENDING</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
