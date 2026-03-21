<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('common-style.css') }}" />
  <link rel="stylesheet" href="{{ asset('product-style.css') }}">
  {{-- Basket Badge CSS --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  {{-- CSRF Token for AJAX requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Toast Notification Styles --}}
  <style>
    #toast-container { position: fixed; top: 140px; right: 30px; z-index: 99999; display: flex; flex-direction: column; gap: 15px; pointer-events: none; }
    .toast-notification { background: white; min-width: 380px; padding: 20px 25px; border-radius: 12px; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); display: flex; align-items: center; gap: 20px; position: relative; overflow: hidden; pointer-events: auto; transform: translateX(120%); opacity: 0; transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.4s ease; }
    .toast-notification.show { transform: translateX(0); opacity: 1; }
    .toast-icon { font-size: 32px; flex-shrink: 0; }
    .toast-content { flex: 1; display: flex; flex-direction: column; gap: 6px; }
    .toast-title { font-weight: 700; font-size: 16px; color: #111827; }
    .toast-message { font-size: 14px; color: #4b5563; font-weight: 500; }
    .toast-product-image { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; flex-shrink: 0; border: 1px solid #e5e7eb; }
    .toast-progress { position: absolute; bottom: 0; left: 0; height: 5px; width: 100%; animation: shrink 3s linear forwards; }
    @keyframes shrink { to { width: 0%; } }
  </style>  

</head>
<body>
    <header class="main-header">
    <div class="container nav-container">

      <!-- Logo -->
      <a href="/" class="logo"> <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/">Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="/about-us">About</a></li>
          <li><a href="/contact-us">Contact</a></li>
          <li><a href="/displayproduct">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="/my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
        
        {{-- Basket Icon with Badge --}}
        <a href="{{ route('basket.index') }}" class="cart-icon-wrapper">
          <i class="fa-solid fa-cart-shopping"></i>
          
          @php
            use App\Models\BasketItem;
            $basketCount = Auth::check() 
              ? BasketItem::where('user_id', Auth::id())->sum('quantity')
              : BasketItem::where('session_id', session()->getId())->sum('quantity');
          @endphp
          
          @if($basketCount > 0)
            <span class="cart-badge">{{ $basketCount }}</span>
          @endif
        </a>
        
        <a href="/account.html"><i class="fa-regular fa-user"></i></a>
      </div>
    </div>
  </header>

  <main>
      <section class="product-detail">

          {{-- Product Name --}}
          <h1 class="product-name">{{ $product->name }}</h1>

          <div class="product-container">

              {{-- Image --}}
              <div class="product-image-box">
                  @if ($product->image_url)
                      <img src="{{ asset($product->image_url) }}" 
                          alt="{{ $product->name }}" 
                          class="product-image">
                  @else
                      <img src="{{ asset('images/laptop.jpg') }}" 
                          class="product-image">
                  @endif
              </div>

              {{-- Info --}}
              <div class="product-info-box">

                  <div class="product-price-box">
                      <span class="price-label">Price:</span>
                      <span class="price-value">£{{ number_format($product->price, 2) }}</span>
                  </div>

                  <div class="product-description-box">
                      <h3>Description</h3>
                      <p>{{ $product->description }}</p>
                  </div>

                  {{-- Stock --}}
                  <div class="product-stock-box">
                      <h3>Stock Status</h3>
                      <p>
                          {{ $product->stock_status }}
                      </p>
                  </div>
                  
                 <a href="#" class="add-to-cart-btn" 
                  onclick="event.preventDefault(); addToBasketAjax({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->image_url ? asset($product->image_url) : asset('images/laptop.jpg') }}', 1);">
                  Add to Cart
                </a>

              </div>
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
          <li><a href="{{ route('basket.index') }}">Basket</a></li>
          <li><a href="account.html">My Account</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact Info</h4>
        <ul class="contact-list">
          <li>
            <i class="fa-solid fa-location-dot"></i> <!--fa-loocation-dot is a Location Icon linked from Font Awesome-->
            <span>0121 555 0198</span><br><br>
          </li>
          <li>
            <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
            <span>Tecci_Queries@net.com</span><br><br>
          </li>
          <li>
            <i class="fa-regular fa-envelope"></i> <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
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

  <script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// AJAX Add to Basket (NO PAGE REFRESH!)
function addToBasketAjax(productId, productName, productImage, quantity = 1) {
  fetch(`/add-to-basket/${productId}?quantity=${quantity}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'X-Requested-With': 'XMLHttpRequest', 
      'Accept': 'application/json'          
    },
    body: JSON.stringify({ quantity: quantity })
  })
  .then(res => {
      if (!res.ok) throw new Error('Network response was not ok');
      return res.json();
  })
  .then(data => {
    if (data.success) {
      const message = quantity > 1 
        ? `${quantity} × ${productName} added to your basket!`
        : `${productName} added to your basket!`;
      
      showToast("Added to Basket", message, "success", productImage);
      
      // Update header badge
      const cartBadge = document.querySelector('.cart-badge');
      if (cartBadge) {
        cartBadge.innerText = data.totalQty;
        cartBadge.style.display = 'inline-block';
      } else {
        const cartIcon = document.querySelector('.cart-icon-wrapper');
        if (cartIcon) {
          const badge = document.createElement('span');
          badge.className = 'cart-badge';
          badge.innerText = data.totalQty;
          cartIcon.appendChild(badge);
        }
      }
    }
  })
  .catch(err => console.error("Add to basket error:", err));
}

// Toast Notification Function 
function showToast(title, message, type = 'success', imageUrl = null) {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast-notification'; 
  
  const color = type === 'success' ? '#2ecc71' : '#e74c3c';
  const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
  
  const imageHtml = imageUrl ? `<img src="${imageUrl}" class="toast-product-image" alt="Product">` : `<div class="toast-icon" style="color: ${color}">${icon}</div>`;
  
  toast.style.borderLeft = `5px solid ${color}`;
  toast.innerHTML = `
    ${imageHtml}
    <div class="toast-content">
      <span class="toast-title" style="color: #333">${title}</span>
      <span class="toast-message">${message}</span>
    </div>
    <div class="toast-progress" style="background-color: ${color}"></div>
  `;
  
  container.appendChild(toast);
  
  setTimeout(() => toast.classList.add('show'), 10);
  
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400); 
  }, 3000);
}
</script>

</html>
