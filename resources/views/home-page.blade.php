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
  {{-- Basket Badge CSS --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
   <link rel="stylesheet" href="{{ asset('chatbot.css') }}">

</head>
<!-- Linking the chatbot-->
 @include('partials.chatbot')
<script src="{{ asset('chatbot.js') }}"></script>


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
        <a href="my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>

        {{-- Basket Icon with Badge --}}
        <a href="basket" class="cart-icon-wrapper">
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

        @if(Auth::check())
            {{-- If logged in, check if they are an admin --}}
            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : url('account') }}">
                <i class="fa-regular fa-user"></i>
            </a>
        @else
            {{-- If not logged in, just go to the login page --}}
            <a href="{{ url('login') }}">
                <i class="fa-regular fa-user"></i>
            </a>
        @endif
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Switch to dark mode">
            <i class="fa-solid fa-moon"></i>
            <!--fa-moon is a Moon Icon linked from Font Awesome-->
            <!--class="theme-toggle" lets us style the button using CSS-->
            <!--id="themeToggle" allows us to use this id in JavaScript-->
        </button>
      </div>
    </div>
  </header>

  <!--HERO SECTION-->
    <section class="hero">
    <div class="hero-slider"> <!--This wraps the fuller slider system-->
        <div class="hero-track" id="heroTrack"> <!--This is the moving strip that contains all slides-->

            <!--SLIDE 1-->
            <div class="hero-slide"> <!--This creates one single slide inside the slider-->
                <div class="container hero-inner">

                    <div class="hero-text"> <!--This is for the left column of the slide-->
                        <h1>
                            <span class="special-word">Affordable</span>
                            <span>Tech.</span>
                            <span class="special-word">Unbeatable</span>
                            <span>Style.</span>
                        </h1>

                        <p class="hero-subtitle">
                            Smart gadgets and sleek devices, priced for University Students.
                        </p>

                        <a href="/displayproduct" class="btn btn-primary">Shop Now</a>
                    </div>

                    <div class="hero-banner">
                        <img src="https://i.ibb.co/XfxPXyL5/Hero-Section-Image.webp"
                             alt="Student using a laptop from Tecci"
                             class="hero-image">
                    </div>
                </div>
            </div>

            <!--SLIDE 2-->
            <div class="hero-slide"> <!--This creates one single slide inside the slider-->
                <div class="container hero-inner">

                    <div class="hero-text"> <!--This is for the left column of the slide-->
                        <h1>
                            <span class="special-word">Why</span>
                            <span>Choose Us?</span>
                        </h1>

                        <p class="hero-subtitle">
                            We curate tech that balances performance, price and style, so you can focus on your studies, not your budget.
                        </p>

                        <a href="/about-us" class="btn btn-primary">Learn More</a>
                    </div>

                    <div class="hero-banner">
                        <img src="Images\Top-Right-Team-Image.png"
                             alt="Students collaborating around a table"
                             class="hero-image">
                    </div>
                </div>
            </div>

            <!--SLIDE 3-->
            <div class="hero-slide"> <!--This creates one single slide inside the slider-->
                <div class="container hero-inner">

                    <div class="hero-text"> <!--This is for the left column of the slide-->
                        <h1>
                            <span class="special-word">Lock In Your Summer Setup</span>
                            <span>With 25% Off</span>
                        </h1>

                        <p class="hero-subtitle">
                            Get ahead before summer starts. Enjoy <strong>25% off laptops</strong> built for Uni life.
                        </p>

                        <p class="hero-offer-code">
                            Use code <strong>SUMMER25</strong> at checkout
                        </p>

                        <a href="/displayproduct?category=laptops" class="btn btn-primary">View Laptops</a>
                    </div>

                    <div class="hero-banner">
                        <img src="Images\Rotating Banner Laptop Sale.png"
                             alt="Tecci big savings laptop promotion"
                             class="hero-image">
                    </div>
                </div>
            </div>
        </div>

        <button class="hero-arrow" id="heroNextBtn" aria-label="Next slide"> <!--This creates the circular right arrow Button-->
            <i class="fa-solid fa-chevron-right"></i> <!--fa-chevron-right is a Right Arrow Icon linked from Font Awesome-->
        </button>
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

        <a href="/displayproduct?category=desktops" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-desktop"></i> <!--fa-desktop is a Desktop Icon linked from Font Awesome-->
          </div>
          <p>PCs</p>
        </a>

        <a href="/displayproduct?category=laptops" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-laptop"></i> <!--fa-laptop is a Laptop Icon linked from Font Awesome-->
          </div>
          <p>Laptops</p>
        </a>

        <a href="/displayproduct?category=phones" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-mobile-screen-button"></i> <!--fa-mobile-screen-button is a Mobile Icon linked from Font Awesome-->
          </div>
          <p>Smartphones</p>
        </a>

        <a href="/displayproduct?category=tablets" class="category-card">
          <div class="category-icon">
            <i class="fa-solid fa-tablet-screen-button"></i> <!--fa-tablet-screen-button is a Tablet Icon linked from Font Awesome-->
          </div>
          <p>Tablets</p>
        </a>

        <a href="/displayproduct?category=accessories" class="category-card">
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
<!-- LEAVE US A REVIEW -->
<section class="review-section">
    <div class="container review-inner">
        <h2>Leave Us A Review</h2>

        <p class="review-intro">
            Based on my visit today, the service provided by Tecci has been...
        </p>

        @if(session('success'))
            <p style="color: green; font-weight: 700; margin-bottom: 15px;">
                {{ session('success') }}
            </p>
        @endif

        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="review-form" action="{{ route('website.reviews.store') }}" method="POST">
            @csrf

            <input type="hidden" name="rating" id="ratingInput" value="0">

            <div style="margin-bottom: 20px;">
                <label for="reviewName" class="review-text-label">Your Name</label>
                <input
                    type="text"
                    id="reviewName"
                    name="name"
                    class="review-textarea"
                    placeholder="Optional"
                    style="min-height: 50px;"
                >
            </div>

            <div class="review-rating-wrap">
                <span class="review-label-left">Poor</span>

                <div class="star-rating" id="starRating">
                    <i class="fa-regular fa-star star" data-value="1" aria-label="1 star"></i>
                    <i class="fa-regular fa-star star" data-value="2" aria-label="2 stars"></i>
                    <i class="fa-regular fa-star star" data-value="3" aria-label="3 stars"></i>
                    <i class="fa-regular fa-star star" data-value="4" aria-label="4 stars"></i>
                    <i class="fa-regular fa-star star" data-value="5" aria-label="5 stars"></i>
                </div>

                <span class="review-label-right">Excellent</span>
            </div>

            <label for="reviewMessage" class="review-text-label">Tell us more about your experience</label>

            <textarea
                id="reviewMessage"
                name="message"
                class="review-textarea"
                placeholder="Write your review here..."
                rows="7"
                required
            ></textarea>

            <button type="submit" class="btn btn-primary review-submit-btn">Submit Review</button>
        </form>
    </div>
</section>

<section class="reviews-carousel-section">
    <div class="container">
        <h2>What Our Customers Say</h2>

        @if($reviews->isEmpty())
            <p>No reviews yet.</p>
        @else
            <div class="reviews-carousel-wrapper">
                <button type="button" class="carousel-btn prev" onclick="moveReviewSlide(-1)">&#10094;</button>

                <div class="reviews-carousel" id="reviewsCarousel">
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="review-stars-display">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                            <p class="review-message">"{{ $review->message }}"</p>
                            <p class="review-name">— {{ $review->name ?: 'Anonymous' }}</p>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="carousel-btn next" onclick="moveReviewSlide(1)">&#10095;</button>
            </div>
        @endif
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
  <script src="home-page.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#starRating .star');
    const ratingInput = document.getElementById('ratingInput');

    function paintStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));

            if (starValue <= value) {
                star.classList.remove('fa-regular');
                star.classList.add('fa-solid');
                star.style.color = '#f4b400';
            } else {
                star.classList.remove('fa-solid');
                star.classList.add('fa-regular');
                star.style.color = '';
            }
        });
    }

    if (stars.length && ratingInput) {
        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                paintStars(value);
            });
        });
    }
});

function moveReviewSlide(direction) {
    const carousel = document.getElementById('reviewsCarousel');
    if (!carousel) return;

    carousel.scrollLeft += direction * 320;
}
</script>
</script>

</body>

</html>
