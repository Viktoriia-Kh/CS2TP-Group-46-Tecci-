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
<div class="detail-row" style="display: block;"> <div style="display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center;">
          <img src="{{ asset($item->image_url) }}" alt="{{ $item->product_name }}" class="product-img">
          <div>
              <strong>{{ $item->product_name }}</strong><br>
              <small>Quantity: {{ $item->quantity }} | £{{ number_format($item->price, 2) }}</small>
          </div>
      </div>
      
      <div>
          @if(!$item->return_status)
              <button onclick="toggleReturnForm({{ $item->id }})" style="padding: 8px 15px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                  Return Item
              </button>
          @else
              <span style="padding: 5px 10px; background: #ffeeba; color: #856404; border-radius: 15px; font-size: 0.8rem; font-weight: bold;">
                  Return: {{ $item->return_status }}
              </span>
          @endif
      </div>
  </div>

  <div id="return-form-{{ $item->id }}" style="display: none; margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #ddd;">
      <form action="{{ route('item.return', $item->id) }}" method="POST">
          @csrf
          <label style="font-weight: bold; font-size: 0.9rem;">Reason for return:</label>
          <textarea name="return_reason" required placeholder="E.g., Item arrived damaged, changed my mind..." style="width: 100%; height: 60px; padding: 10px; margin-top: 5px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>
          
          <button type="submit" style="background: #03315b; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">
              Submit Request
          </button>
          <button type="button" onclick="toggleReturnForm({{ $item->id }})" style="background: transparent; color: #666; border: none; margin-left: 10px; cursor: pointer;">
              Cancel
          </button>
      </form>
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

<script>
    function toggleReturnForm(itemId) {
        var formContainer = document.getElementById('return-form-' + itemId);
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    }
</script>