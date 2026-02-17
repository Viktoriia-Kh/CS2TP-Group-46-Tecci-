<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tecci | Order Details #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('orderdetailstyle.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
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

<div class="details-container">
    <a href="{{ route('orders.index') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to My Orders</a>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Order #{{ $order->id }}</h2>
        <span class="status-badge">{{ $order->status }}</span>
    </div>
    
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

    <h3 style="margin-top: 30px; border-bottom: 2px solid #03315b; padding-bottom: 10px;">Items Ordered</h3>
    
    @foreach($order->items as $item)
    <div class="detail-row">
        <div style="display: flex; align-items: center;">
            <img src="{{ asset($item->image_url) }}" alt="{{ $item->product_name }}" class="product-img" onerror="this.src='https://via.placeholder.com/80';">
            <div>
                <strong>{{ $item->product_name }}</strong><br>
                <small>Quantity: {{ $item->quantity }}</small>
            </div>
        </div>
        <div>
            £{{ number_format($item->price * $item->quantity, 2) }}
              <button type="submit" 
              style="width: 80%; padding: 5px; background: #005baf; color: white; border: none; font-size: 0.8rem; font-weight: bold; border-radius: 2px; cursor: pointer; transition: background 0.2s;">
               Return item
            </button>
            
        </div>
    </div>
    @endforeach

    <div style="margin-top: 20px; text-align: right;">
        <h4>Total Paid: <span style="color: #005baf; font-size: 1.5rem;">£{{ number_format($order->total_price, 2) }}</span></h4>
    </div>
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