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
<!--The Logo and Menu Button are now grouped together on the left-->
<div class="header-left-group">

<!--Logo-->
<a href="/" class="logo">
<!--Using this will make the Logo clickable and takes the user to the Home Page-->
<img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
<span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
</a>

<!--ADMIN HEADER CONTROLS (MENU + SEARCH)-->
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

<a class="sidebar-logout" href="/">LOGOUT</a>

<!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
<nav class="admin-nav">
<a class="active" href="/admin-dashboard">
<span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
<span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
</a>

<a href="/admin-orders">
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

<!--CONTENT-->
<section class="admin-content">
<div class="admin-content-inner">

<!--PAGE TITLE-->
<div class="dash-title">
<p class="dash-kicker">This Is Your Dashboard</p> <!--class="dash-kicker" is used to separate the small contextual label from large headline-->
<h1>Hello Admin</h1>
</div>

<!--The Search Bar has been moved under the page heading-->
<div class="dashboard-search-row"> <!--This is a wrapper for styling purpose of the Search Bar-->
<div class="page-search-wrap">
<!--fa-magnifying-glass is a Magnifying Glass Icon linked from Font Awesome-->
<i class="fa-solid fa-magnifying-glass"></i> <!--This creates a Magnifying Glass Icon which is just purely visual for now-->
<input type="text" placeholder="Search" aria-label="Search (visual only)">
</div>
</div>

<!--TOP GRID: CARDS + ACTIVITY-->
<div class="dash-top-grid">
<div class="dash-cards">


<article class="metric-card">
<p class="metric-label">Sales | Today</p>
<div class="metric-body">
<div class="metric-icon">
<i class="fa-solid fa-cart-shopping"></i>
</div>
<p class="metric-value">{{ number_format($salesToday) }}</p>
</div>
</article>

<article class="metric-card">
<p class="metric-label">Revenue | This Month</p>
<div class="metric-body">
<div class="metric-icon">
<i class="fa-solid fa-circle-dollar-to-slot"></i>
</div>
<p class="metric-value">£{{ number_format($revenueMonth, 2) }}</p>
</div>
</article>
<section class="panel table-panel" style="margin: 0;">
    <div class="panel-header">
        <h2>Recent Sales | Today</h2>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->user->name ?? 'Guest' }}</td>
                    <td>£{{ number_format($sale->total_price, 2) }}</td>
                    <td><span class="pill pill-approved">{{ strtoupper($sale->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;">No recent sales.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>


<aside class="panel stock-alerts-panel"> <!-- adding an out of stock panel to the right of the top selling panel-->
<div class="panel-header">
<h2>Items Out Of Stock</h2>
</div>

<div class="table-wrap">
<ul class="stock-alert-list">
    @forelse($itemsOutOfStock as $item) {{-- this loop will check if the items are out of stock--}}
        <li class="stock-item">
            <span class="stock-name">{{$item->product->name}}</span>
            <span class="stock-status">OUT OF STOCK</span>
        </li>
    @empty
        {{-- this will show if there are no products out of stock--}}
        <li class="stock-message">No products currently out of stock.</li>
    @endforelse
</ul>
</div>

</aside>



</div>


<!--panel is a shared styling class, used so any element with class panel gets a blue background, rounded corners, and padding-->
<aside class="panel activity-panel">
<div class="panel-header">
<h2>Refund Requests</h2>
</div>

<ul class="activity-timeline" style="list-style: none; padding: 0;">

@forelse($refundRequests as $request)
<li class="activity-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1); position: relative;">

<div style="flex: 1; padding-left: 15px;">
    <span class="activity-time" style="font-size: 11px; color: #a5c7e9;">
        {{ $request->updated_at->diffForHumans(null, true) }}
    </span>

    <p class="activity-text" style="margin: 4px 0; color: #fff;">
        <strong>Order #{{ $request->order_id }}</strong>
        <span style="color: #7fc0ff;">({{ $request->product_name }})</span>
    </p>

    @if($request->return_reason)
<p style="font-size: 12px; color: #d1e7ff; background: rgba(255,255,255,0.05); padding: 5px 8px; border-left: 2px solid #7fc0ff; margin: 5px 0 10px 0; font-style: italic;">
"{{ $request->return_reason }}"
</p>
@else
<p style="font-size: 11px; color: #a5c7e9; margin-bottom: 10px;">No reason provided.</p>
@endif

    <span class="pill {{ strtolower($request->return_status) == 'pending' ? 'pill-pending' : 'pill-approved' }}" style="font-size: 10px;">
        {{ strtoupper($request->return_status) }}
    </span>
</div>

<div class="dash-action-btns" style="display: flex; gap: 8px; margin-left: 10px;">
@php
$status = strtolower(trim($request->return_status));
@endphp

@if($status != 'approved' && $status != 'declined' && $status != 'none')
<form action="{{ route('admin.returns.approve', $request->id) }}" method="POST" style="margin: 0;">
@csrf
<button type="submit" class="pill pill-approved" title="Approve" style="cursor: pointer; border: none; padding: 8px 12px; background: #1cc95b; color: white;">
<i class="fa-solid fa-check"></i>
</button>
</form>

<form action="{{ route('admin.returns.decline', $request->id) }}" method="POST" style="margin: 0;">
@csrf
<button type="submit" class="pill" title="Decline" style="cursor: pointer; border: none; background: #e74c3c; color: white; padding: 8px 12px;">
<i class="fa-solid fa-xmark"></i>
</button>
</form>
@else
{{-- This shows once you have clicked a button --}}
<div style="text-align: center; min-width: 40px;">
<i class="fa-solid fa-circle-check" style="color: #1cc95b; font-size: 1.2rem;" title="Processed"></i>
</div>
@endif
</div>
</li>
@empty
<li class="activity-item">
<p class="activity-text" style="color: #a5c7e9; text-align: center; padding: 20px;">No active refund requests.</p>
</li>
@endforelse
</ul>
</aside>
</div>







</section>
</main>

<!--FOOTER-->
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
