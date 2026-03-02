<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('common-style.css') }}" />
  <link rel="stylesheet" href="{{ asset('product-style.css') }}">
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
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a> <!--fa-heart is a Heart Icon linked from Font Awesome-->
        <a href="{{ route('basket.index') }}"><i class="fa-solid fa-cart-shopping"></i></a> <!--fa-cart-shopping is a Shopping Cart Icon linked from Font Awesome-->
        <a href="account.html"><i class="fa-regular fa-user"></i></a> <!--fa-user is a User Icon linked from Font Awesome-->
      </div>
    </div>
  </header>

  <main>
    <section class="product-detail">

        <!-- TOP ROW: Name (Left) | Price & Basket (Right) -->
        <div class="product-header-row">
            
            <!-- Name -->
            <h1 class="product-name">{{ $product->name }}</h1>

            <!-- Price & Add to Basket -->
            <div class="product-actions">
                <div class="product-price-box">
                    <span class="price-value">
                        £{{ number_format($product->price, 2) }}
                    </span>
                </div>
                
                <a href="{{ route('basket.add', $product->id) }}" class="add-to-basket-btn"> Add to Basket</a>
            </div>
        </div>

        <!-- MAIN CONTENT GRID -->
        <div class="product-container">
            <!-- LEFT COLUMN: Images & Rating -->
            <div class="left-column">
                <!-- Image Area: Thumbnails + Main Image -->
                <div class="image-gallery-wrapper">
                    <div class="thumbnails-column">
                        <!-- Placeholder loop for thumbnails based on sketch -->
                        @for($i = 0; $i < 3; $i++)
                            <div class="thumb">
                                <!-- Replace with actual gallery images -->
                                <img src="{{ asset('images/placeholder-thumb.jpg') }}">
                            </div>
                        @endfor
                    </div>

                    <!-- Main Image -->
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
                </div>

                <!-- Rating Section -->
                <div class="product-rating-box">
                    <span class="rating-label">Rating:</span>
                    <!-- Placeholder stars -->
                    <span class="stars">★★★★☆</span>
                </div>
            </div>

            <!-- RIGHT COLUMN: Product Details & Stock -->
            <div class="right-column" ">
                
                <div class="product-description-box">
                    <h3 style="margin-top: 0;">Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Stock Status  -->
                <div class="product-stock-box" >
                    <span class="stock-status">
                        {{ $product->stock_status }}
                    </span>
                </div>

            </div>
        </div>
        <div class="product-tabs-section">
          <div class="tabs-nav">
            <button class="tab-btn active" onclick="openTab(event, 'tech-specs')">Tech Specs</button>
            <button class="tab-btn" onclick="openTab(event, 'features-design')">Features & Design</button>
            <button class="tab-btn" onclick="openTab(event, 'reviews')">Reviews</button>
          </div>

          <div class="tabs-content"> 
              <div id="tech-specs" class="tab-pane active">
                  <h3>Technical Specifications</h3>
                  <p>Some technical specs</p>
              </div>

              <div id="features-design" class="tab-pane">
                  <h3>Features & Design</h3>
                  <p>Some features and design</p>
              </div>

              <div id="reviews" class="tab-pane">
                  <h3>Customer Reviews</h3>
                  <p>some customer reviews</p>
              </div>

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

