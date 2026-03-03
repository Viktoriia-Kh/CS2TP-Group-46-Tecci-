<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Your Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('paymentstyle.css') }}" />
  <link rel="stylesheet" href="{{ asset('common-styles.css') }}" />
  <link rel="stylesheet" href="{{ asset('contactstyle.css') }}" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>

<body>
  <header class="main-header">
    <div class="container nav-container">

      <!-- Logo -->
      <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="{{ route('products.index') }}">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a>
        <a href="{{ route('basket.index') }}"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="login"><i class="fa-regular fa-user"></i></a>
      </div>
    </div>
  </header>

  <section class="hero">
<div class="payment-container" style="max-width: 500px; margin: 50px auto; padding: 30px; border: 1px solid #ddd; border-radius: 10px;">
    <h2 style="color: #03315b; margin-bottom: 20px;">Secure Payment</h2>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payment.validate') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Name on Card</label><br>
            <input type="text" name="card_name" value="{{ old('card_name') }}" required style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Card Number</label><br>
            <input type="text" name="card_number" maxlength="16" placeholder="1234567812345678" inputmode="numeric" required style="width: 100%; padding: 10px;">
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label>Expiry (MM/YY)</label>
                <input type="text" name="expiry_date" maxlength="5" placeholder="MM/YY" required style="width: 100%; padding: 10px;">
            </div>
            <div style="flex: 1;">
                <label>CVV</label>
                <input type="text" name="cvv" maxlength="3" placeholder="123" inputmode="numeric" required style="width: 100%; padding: 10px;">
            </div>
        </div>

        <button type="submit" style="width: 100%; background: #005baf; color: white; padding: 15px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            Confirm & Pay
        </button>
    </form>
</div>
  </div>
  <!-- CHECKOUT SECTION END -->



</div>

  <!--FEATURED PRODUCTS-->
 <section class="featured-products" id="featured">
    <div class="container">
      <h2>Featured Products</h2>
      <div class="card-grid product-grid">

    @forelse ($featuredProducts as $product)
        <a href="{{ url('product/' . $product->id) }}" class="product-card">

            <div class="product-image-placeholder">
                @if ($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/Laptop.PNG') }}" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="product-info">
                <p class="product-name">{{ $product->name }}</p>
                <p class="product-price">£{{ number_format($product->price, 2) }}</p>
            </div>

        </a>
    @empty
        <p>No products available.</p>
    @endforelse
  </section>

  <!--PRODUCT CATEGORIES-->
  <section class="product-categories">
    <div class="container">
      <h2>Shop All Products Now</h2>
      <div class="card-grid category-grid">
        <a href="{{ route('products.index') }}" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-laptop"></i>
          </div>
          <p>Laptops</p>
        </a>

        <a href="{{ route('products.index') }}" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-desktop"></i>
          </div>
          <p>PCs</p>
        </a>

        <a href="{{ route('products.index') }}" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-mobile-screen-button"></i>
          </div>
          <p>Smartphones</p>
        </a>

        <a href="{{ route('products.index') }}" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-tablet-screen-button"></i>
          </div>
          <p>Tablets</p>
        </a>

        <a href="{{ route('products.index') }}" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-headphones"></i>
          </div>
          <p>Accessories</p>
        </a>
      </div>
    </div>
  </section>



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