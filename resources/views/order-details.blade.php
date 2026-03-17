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
<p style="color: red;">DEBUG: First item status is: "{{ $order->items->first()->return_status ?? 'NULL' }}"</p>
<div class="item-card" style="border-bottom: 1px solid #eee; padding: 20px 0; display: flex; flex-direction: column;">

<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
  
  <div style="display: flex; align-items: center;">
      <img src="{{ asset($item->image_url) }}" alt="{{ $item->product_name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
      <div>
          <h4 style="margin: 0; color: #03315b;">{{ $item->product_name }}</h4>
          <p style="margin: 5px 0; color: #666; font-size: 0.9rem;">Qty: {{ $item->quantity }} | £{{ number_format($item->price, 2) }}</p>
      </div>
  </div>

<div style="text-align: right;">
  {{-- Check for null, empty, OR the specific word "none" --}}
  @if(empty($item->return_status) || $item->return_status == 'none')
      <button type="button" onclick="toggleReturnForm({{ $item->id }})" 
              style="background: #e74c3c; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s;">
          Return Item
      </button>
  @else
      <span style="display: inline-block; padding: 6px 12px; background: #fff4e5; color: #d35400; border: 1px solid #ffe3b3; border-radius: 4px; font-weight: bold; font-size: 0.85rem;">
          <i class="fa-solid fa-clock-rotate-left"></i> Return {{ $item->return_status }}
      </span>
  @endif
</div>
</div>

<div id="return-form-{{ $item->id }}" style="display: none; width: 100%; margin-top: 20px; background: #fdfdfd; padding: 20px; border: 1px dashed #cbd5e0; border-radius: 8px;">
    <form action="{{ route('item.return', $item->id) }}" method="POST">
        @csrf
        <label style="display: block; font-weight: bold; margin-bottom: 10px; color: #03315b;">Reason for Return</label>
        
        <select name="return_reason" required 
                style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-family: inherit; margin-bottom: 15px; background-color: white;">
            <option value="" disabled selected>Please select a reason...</option>
            <option value="Wrong item sent">Wrong item sent</option>
            <option value="Item is defective">Item is defective</option>
            <option value="Missed delivery date">Missed delivery date</option>
            <option value="No reason given">No reason given</option>
        </select>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #03315b; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Confirm Return Request
            </button>
            <button type="button" onclick="toggleReturnForm({{ $item->id }})" style="background: none; border: 1px solid #ccc; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
                Cancel
            </button>
        </div>
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
const form = document.getElementById('return-form-' + itemId);
if (form.style.display === 'none' || form.style.display === '') {
    form.style.display = 'block';
} else {
    form.style.display = 'none';
}
}
</script>