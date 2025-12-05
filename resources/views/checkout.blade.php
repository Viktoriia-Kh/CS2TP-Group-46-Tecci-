<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Your Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('checkoutstyle.css') }}" />
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

  <!-- MAIN CHECKOUT SECTION -->
  <div class="checkout-container container" style="margin-top: 2rem; margin-bottom: 4rem;">

    @if(session('success'))
      <div class="success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        {{ session('success') }}
      </div>
    @endif

    <!-- 1. EMPTY CART STATE (Updated for Arrays) -->
    @if(empty($cart))
      <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
        <h2 style="color: #333;">Your cart is currently empty</h2>
        <p style="color: #666; margin-bottom: 30px;">Looks like you haven't added any tech yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="background: #005baf; color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none;">
          Start Shopping
        </a>
      </div>
    
    @else

      <div class="checkout-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <!-- 2. LEFT COLUMN: ITEMS LIST -->
        <div class="cart-items-list">
          <!-- Updated count() for Array -->
          <h3 style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">Your Items ({{ count($cart) }})</h3>
          
          @foreach ($cart as $item)
            <div class="cart-item" style="display: flex; gap: 20px; padding: 20px; background: #fff; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); align-items: center;">
              
              <!-- Product Image (Updated to Array Syntax) -->
              <div class="item-image">
                <img src="{{ filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : asset($item['image']) }}" 
                     alt="{{ $item['name'] }}" 
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px;"
                     onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
              </div>

              <!-- Product Details (Updated to Array Syntax) -->
              <div class="item-details" style="flex-grow: 1;">
                <!-- Used $item['name'] instead of ->product -->
                <h4 style="margin: 0 0 5px 0; color: #03315b; font-size: 1.1rem;">{{ $item['name'] }}</h4>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                  Price: £{{ number_format($item['price'], 2) }}
                </p>
                <div style="margin-top: 10px; font-size: 0.9rem;">
                  Quantity: <strong>{{ $item['quantity'] }}</strong>
                </div>
              </div>

              <!-- Line Total (Updated to Array Syntax) -->
              <div class="item-total" style="text-align: right;">
                <span style="display: block; font-size: 1.2rem; font-weight: bold; color: #333;">
                  £{{ number_format($item['price'] * $item['quantity'], 2) }}
                </span>
              </div>
            </div>
          @endforeach
        </div>

        <!-- 3. RIGHT COLUMN: SUMMARY & PAY -->
        <div class="cart-summary">
          <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); position: sticky; top: 20px;">
            <h3 style="margin-top: 0; color: #03315b;">Order Summary</h3>
            
            <div style="display: flex; justify-content: space-between; margin-top: 20px; margin-bottom: 10px; color: #666;">
              <span>Subtotal</span>
              <span>£{{ number_format($total, 2) }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; color: #666;">
              <span>Shipping</span>
              <!-- NOTE: This is currently hardcoded as Free/TBD until we pass delivery info -->
              <span>Calculated at next step</span>
            </div>

            <div style="border-top: 2px solid #eee; padding-top: 20px; display: flex; justify-content: space-between; margin-bottom: 25px;">
              <span style="font-size: 1.2rem; font-weight: bold;">Total</span>
              <span style="font-size: 1.5rem; font-weight: bold; color: #005baf;">£{{ number_format($total, 2) }}</span>
            </div>

            <button onclick="alert('Payment functionality is currently disabled.')" 
                    style="width: 100%; padding: 15px; background: #005baf; color: white; border: none; font-size: 1.1rem; font-weight: bold; border-radius: 8px; cursor: pointer; transition: background 0.2s;">
              Pay Now
            </button>
            
            <p style="text-align: center; font-size: 0.8rem; color: #999; margin-top: 15px;">
              <i class="fa-solid fa-lock"></i> Secure Checkout
            </p>
          </div>
        </div>

      </div>
    @endif

  </div>
  <!-- CHECKOUT SECTION END -->



</div>

  <!--FEATURED PRODUCTS-->
  <section class="featured-products" id="featured">
    <div class="container">
      <h2>Featured Products</h2>
      <div class="card-grid product-grid"> <!-- This div will hold all 4 Product Cards-->
        <a href="product/1" class="product-card">
          <div class="product-image-placeholder"> <img src="Laptop.PNG" alt="Budget Student Laptop"></div>
          <div class="product-info">
            <p class="product-name">Laptop</p>
            <p class="product-price">£999.00</p>
          </div>
        </a>

        <a href="product/2" class="product-card">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <p class="product-name">Item Name</p>
            <p class="product-price">£XXX.XX</p>
          </div>
        </a>

        <a href="product/3" class="product-card">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <p class="product-name">Item Name</p>
            <p class="product-price">£XXX.XX</p>
          </div>
        </a>

        <a href="product/4" class="product-card">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <p class="product-name">Item Name</p>
            <p class="product-price">£XXX.XX</p>
          </div>
        </a>
      </div> <!--Closes .card-grid product-grid-->
    </div> <!--Closes .container-->
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