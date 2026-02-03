<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="homestyle.css" />
  <link rel="stylesheet" href="contactstyle.css" />
  <link rel="stylesheet" href="Dark-Mode.css" />
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
        <span class="logo-text">TECCI</span> <!--Is an inline element used for short text-->
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/" class="active">Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="displayproduct">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a> <!--fa-heart is a Heart Icon linked from Font Awesome-->
        <a href="basket"><i class="fa-solid fa-cart-shopping"></i></a> <!--fa-cart-shopping is a Shopping Cart Icon linked from Font Awesome-->
        <a href="login"><i class="fa-regular fa-user"></i></a> <!--fa-user is a User Icon linked from Font Awesome-->
      </div>
    </div>
  </header>

  <section class="hero">
    <div class="container hero-inner"> <!--.hero-inner used to turn this into a two column layout-->

      <!--Left Side: Text Content-->
      <div class="hero-text">
        <h1>
          <p class="special-word">Affordable<p>
          <p>Tech.</p>
          <p class="special-word">Unbeatable</p>
          <p>Style.</p>
        </h1>
        <p class="hero-subtitle">Smart gadgets and sleek devices, priced for University Students.</p>
        <a href="displayproduct" class="btn btn-primary">Shop Now</a>
      </div>

      <!--Right Side: Hero Image-->
      <div class="hero-banner">
        <img src="https://i.ibb.co/XfxPXyL5/Hero-Section-Image.webp" alt="Student using a laptop from Tecci"
          class="hero-image">
      </div>
    </div>
    </div>
  </section>

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

</div>

    </div> <!--Closes .container-->
  </section>

  <!--PRODUCT CATEGORIES-->
  <section class="product-categories">
    <div class="container">
      <h2>Shop All Products Now</h2>
      <div class="card-grid category-grid">
        <a href="displayproduct" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-laptop"></i> <!--fa-laptop is a Laptop Icon linked from Font Awesome-->
          </div>
          <p>Laptops</p>
        </a>

        <a href="displayproduct" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-desktop"></i> <!--fa-desktop is a Desktop Icon linked from Font Awesome-->
          </div>
          <p>PCs</p>
        </a>

        <a href="displayproduct" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-mobile-screen-button"></i> <!--fa-mobile-screen-button is a Mobile Icon linked from Font Awesome-->
          </div>
          <p>Smartphones</p>
        </a>

        <a href="displayproduct" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-tablet-screen-button"></i> <!--fa-tablet-screen-button is a Tablet Icon linked from Font Awesome-->
          </div>
          <p>Tablets</p>
        </a>

        <a href="displayproduct" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-headphones"></i> <!--fa-headphones is a Headphone Icon linked from Font Awesome-->
          </div>
          <p>Accessories</p>
        </a>
      </div>
    </div>
  </section>

  <!--TESTIMONIALS-->
  <section class="testimonials">
    <div class="container">
      <h2>Testimonials</h2>
      <div class="card-grid testimonial-grid">
        <article class="testimonial-card">
          <div class="testimonial-quote-icon">
            <i class="fa-solid fa-quote-left"></i> <!--fa-quote-left is a Left Quote Icon linked from Font Awesome-->
          </div>
          <p class="testimonial-text">
            As a second-year student on a tight budget, finding good tech actually lasts is hard.
            Tecci has been a life-saver. My laptop arrived quickly, looks premium, and runs my
            coursework apps smoothly. The prices are honestly unbeatable. Highly recommend!
          </p>
          <div class="testimonial-rating">
            <i class="fa-solid fa-star"></i> <!--fa-star is a Star Icon linked from Font Awesome-->
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
          <div class="testimonial-user">
            <div class="avatar">SP</div>
            <div>
              <p class="testimonial-name">Sean Parker</p>
            </div>
          </div>
        </article>

        <article class="testimonial-card">
          <div class="testimonial-quote-icon">
            <i class="fa-solid fa-quote-left"></i> <!--fa-quote-left is a Left Quote Icon linked from Font Awesome-->
          </div>
          <p class="testimonial-text">
            Amazing experience from start to finish. I ordered a refurbished tablet for
            Lectures and it looks brand new! Tecci definitely understands what students
            need - Affordable, reliable tech without the headache.
          </p>
          <div class="testimonial-rating">
            <i class="fa-solid fa-star"></i> <!--fa-star is a Star Icon linked from Font Awesome-->
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
          <div class="testimonial-user">
            <div class="avatar">AR</div>
            <div>
              <p class="testimonial-name">Aisha Rahman</p>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <div class="testimonial-quote-icon">
            <i class="fa-solid fa-quote-left"></i> <!--fa-quote-left is a Left Quote Icon linked from Font Awesome-->
          </div>
          <p class="testimonial-text">
            I'm not a student, but I needed an affordable laptop for working from home and Tecci
            offered much better prices than the high-street stores. The device performs really well
            for everyday tasks, and delivery was fast and hassle-free. I'm giving 4 stars only
            because the model I wanted was temporarily out of stock. Overall, very satisfied.
          </p>
          <div class="testimonial-rating">
            <i class="fa-solid fa-star"></i> <!--fa-star is a Star Icon linked from Font Awesome-->
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </div>
          <div class="testimonial-user">
            <div class="avatar">ML</div>
            <div>
              <p class="testimonial-name">Mei Lin</p>
            </div>
          </div>
        </article>
      </div> <!--Closes each card-->
    </div> <!--Closes .container-->
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
          <li><a href="displayproduct">Products</a></li>
          <li><a href="basket">Basket</a></li>
          <li><a href="login">My Account</a></li>
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

  <!--Link to external JavaScript File-->
    <script src="Dark-Mode-Theme.js"></script>

</body>

</html>