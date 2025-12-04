<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Your Shopping Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="checkoutstyle.css" />
  <link rel="stylesheet" href="contactstyle.css" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>

<body>
  <header class="main-header">
    <div class="container nav-container">

      <!-- Logo -->
      <a href="home-page-2.blade.php" class="logo"> <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span> <!--Is an inline element used for short text-->
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="index.html" class="active">Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="about.html">About</a></li>
          <li><a href="contact-us-2.blade.php">Contact</a></li>
          <li><a href="products.html">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a> <!--fa-heart is a Heart Icon linked from Font Awesome-->
        <a href="basket.html"><i class="fa-solid fa-cart-shopping"></i></a> <!--fa-cart-shopping is a Shopping Cart Icon linked from Font Awesome-->
        <a href="account.html"><i class="fa-regular fa-user"></i></a> <!--fa-user is a User Icon linked from Font Awesome-->
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

    <!-- 1. EMPTY CART STATE -->
    @if($cart->isEmpty())
      <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
        <h2 style="color: #333;">Your cart is currently empty</h2>
        <p style="color: #666; margin-bottom: 30px;">Looks like you haven't added any tech yet.</p>
        <a href="products.html" class="btn btn-primary" style="background: #005baf; color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none;">
          Start Shopping
        </a>
      </div>
    
    @else

      <div class="checkout-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <!-- 2. LEFT COLUMN: ITEMS LIST -->
        <div class="cart-items-list">
          <h3 style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">Your Items ({{ $cart->count() }})</h3>
          
          @foreach ($cart as $item)
            <div class="cart-item" style="display: flex; gap: 20px; padding: 20px; background: #fff; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); align-items: center;">
              
              <!-- Product Image -->
              <div class="item-image">
                <img src="{{ $item->image_url ?? 'https://via.placeholder.com/150' }}" 
                     alt="{{ $item->product }}" 
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px;">
              </div>

              <!-- Product Details -->
              <div class="item-details" style="flex-grow: 1;">
                <h4 style="margin: 0 0 5px 0; color: #03315b; font-size: 1.1rem;">{{ $item->product }}</h4>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                  Price: £{{ number_format($item->price, 2) }}
                </p>
                <div style="margin-top: 10px; font-size: 0.9rem;">
                  Quantity: <strong>{{ $item->quantity }}</strong>
                </div>
              </div>

              <!-- Line Total -->
              <div class="item-total" style="text-align: right;">
                <span style="display: block; font-size: 1.2rem; font-weight: bold; color: #333;">
                  £{{ number_format($item->price * $item->quantity, 2) }}
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
              <span>Free</span>
            </div>

            <div style="border-top: 2px solid #eee; padding-top: 20px; display: flex; justify-content: space-between; margin-bottom: 25px;">
              <span style="font-size: 1.2rem; font-weight: bold;">Total</span>
              <span style="font-size: 1.5rem; font-weight: bold; color: #005baf;">£{{ number_format($total, 2) }}</span>
            </div>

            <button onclick="alert('Payment functionality is currently disabled.')" 
                    style="width: 100%; padding: 15px; background: #005baf; color: white; border: none; font-size: 1.1rem; font-weight: bold; border-radius: 8px; cursor: pointer; transition: background 0.2s;">
              Checkout
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
        <a href="product-1.html" class="product-card">
          <div class="product-image-placeholder"> <img src="Laptop.PNG" alt="Budget Student Laptop"></div>
          <div class="product-info">
            <p class="product-name">Laptop</p>
            <p class="product-price">£999.00</p>
          </div>
        </a>

        <a href="product-2.html" class="product-card">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <p class="product-name">Item Name</p>
            <p class="product-price">£XXX.XX</p>
          </div>
        </a>

        <a href="product-3.html" class="product-card">
          <div class="product-image-placeholder"></div>
          <div class="product-info">
            <p class="product-name">Item Name</p>
            <p class="product-price">£XXX.XX</p>
          </div>
        </a>

        <a href="product-4.html" class="product-card">
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
        <a href="products.html" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-laptop"></i> <!--fa-laptop is a Laptop Icon linked from Font Awesome-->
          </div>
          <p>Laptops</p>
        </a>

        <a href="products.html" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-desktop"></i> <!--fa-desktop is a Desktop Icon linked from Font Awesome-->
          </div>
          <p>PCs</p>
        </a>

        <a href="products.html" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-mobile-screen-button"></i> <!--fa-mobile-screen-button is a Mobile Icon linked from Font Awesome-->
          </div>
          <p>Smartphones</p>
        </a>

        <a href="products.html" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-tablet-screen-button"></i> <!--fa-tablet-screen-button is a Tablet Icon linked from Font Awesome-->
          </div>
          <p>Tablets</p>
        </a>

        <a href="products.html" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-headphones"></i> <!--fa-headphones is a Headphone Icon linked from Font Awesome-->
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
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="products.html">Products</a></li>
          <li><a href="basket.html">Basket</a></li>
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
    </div> <!--Closes <div class="container footer-inner"-->
    <div class="footer-bottom">
      <p>&copy; 2025 Tecci. All rights reserved.</p>
    </div>
  </footer>

</body>

</html>