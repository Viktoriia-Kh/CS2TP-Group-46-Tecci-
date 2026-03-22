<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tecci | Your Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('common-style.css') }}" />
  <link rel="stylesheet" href="{{ asset('myordersstyle.css') }}" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

   
</head>
<body>

    <header class="main-header">
        <div class="container nav-container">
            <a href="/" class="logo">
                <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
                <span class="logo-text">TECCI</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="orders-container">
        <h2 style="margin-bottom: 30px; color: #03315b;">Your Order History</h2>

        @forelse($orders as $order)
            <div class="order-card">
                <div class="order-info">
                    <h3>Order #{{ $order->id }}</h3>
                    <div class="order-meta">
                        Placed on {{ $order->created_at->format('d M, Y') }}
                    </div>
                    <div class="order-status {{ $order->status == 'Delivered' ? 'status-delivered' : 'status-placed' }}">
                        {{ $order->status }}
                    </div>
                </div>

                <div class="order-summary-right" style="text-align: right;">
                    <div class="order-total" style="margin-bottom: 10px;">
                        £{{ number_format($order->total_price, 2) }}
                    </div>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                        View Details & Review
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 50px;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; color: #ccc;"></i>
                <p style="margin-top: 20px; color: #666;">You haven't placed any orders yet.</p>
                <a href="{{ route('products.index') }}" style="color: #005baf;">Go shopping!</a>
            </div>
        @endforelse
    </div>

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
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="{{ route('products.index') }}">Products</a></li>
          <li><a href="{{ route('basket.index') }}">Basket</a></li>
          <li><a href="login">My Account</a></li>
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

</body>

</html>