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
                  
                 <a href="{{ route('basket.add', $product->id) }}" class="add-to-cart-btn"> Add to Cart</a>

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
</html>
