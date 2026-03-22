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
                      @foreach($product->images as $image)
                      <div class="thumb">
                          <img src="{{ asset($image->image_path) }}">
                      </div>
                      @endforeach   
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

                    @php
                        $avgRating = round($product->reviews->avg('rating'));
                        $reviewCount = $product->reviews->count();
                    @endphp

                    <span class="stars">
                        {{ str_repeat('★', $avgRating) }}
                        {{ str_repeat('☆', 5 - $avgRating) }}
                    </span>

                    <span class="review-count">
                        ({{ $reviewCount }} reviews)
                    </span>
                </div>
            </div>

            <!-- RIGHT COLUMN: Product Details & Stock -->
            <div class="right-column">
                
                <div class="product-description-box">
                    <h3 style="margin-top: 0;">Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Stock Status  -->
                <div class="product-stock-box" id="dynamic-stock-box">
                </div>

            </div>
        </div>
        <!-- Tech specs, features and review tabs -->
        <div class="product-tabs-section">
          <div class="tabs-nav">
            <button class="tab-btn active" onclick="openTab(event, 'tech-specs')">Tech Specs</button>
            <button class="tab-btn" onclick="openTab(event, 'reviews')">Reviews</button>
          </div>

          <div class="tabs-content"> 
              <div id="tech-specs" class="tab-pane active">
                <h3 class="tab-title">Technical Specifications</h3>
                <!-- put the data  -->
                <table class="specs-table"> 
                    <tbody>
                    @foreach($product->specs as $spec)
                    <tr>
                    <th class="spec-name">{{ $spec->spec_name }}</th>
                    <td class="spec-value">{{ $spec->spec_value }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>

              <!-- put the data -->
              <div id="reviews" class="tab-pane">
                <h3 class="tab-title">Customer Reviews</h3>
                    
                <div class="reviews-list">
                    @forelse($product->reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <span class="reviewer-name">{{ $review->user->name ?? 'User' }}</span>
                            <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="review-stars">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </div>

                        <p class="review-text">{{ $review->review_text }}</p>
                    </div>
                    @empty
                    <p>No reviews yet.</p>
                    @endforelse
                </div>

                <hr class="review-divider">

                <div class="add-review-section">
                    <form action="{{ route('product.reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h4 class="form-title">Leave a Review</h4>

                        <div class="form-group">
                            <label>Rating</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required>
                                <label for="star5" title="5 stars">
                                    <svg class="star-icon" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>

                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4" title="4 stars">
                                    <svg class="star-icon" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>

                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3" title="3 stars">
                                    <svg class="star-icon" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>

                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2" title="2 stars">
                                    <svg class="star-icon" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>

                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1" title="1 star">
                                    <svg class="star-icon" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment">Your Review</label>
                            <textarea
                                name="comment"
                                id="comment"
                                rows="6"
                                required
                                class="form-control"
                                placeholder="Share your thoughts about the product"
                            ></textarea>
                        </div>

                        <div class="media-upload-group">
                            <input
                                type="file"
                                id="review-media"
                                name="media[]"
                                accept="image/*,video/*"
                                multiple
                                class="hidden-file-input"
                            >

                            <label for="review-media" class="add-media-btn">
                                <svg class="camera-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23 19V5H19L17.17 3H6.83L5 5H1V19H23ZM12 8C14.21 8 16 9.79 16 12C16 14.21 14.21 16 12 16C9.79 16 8 14.21 8 12C8 9.79 9.79 8 12 8Z" fill="#3B82F6"/>
                                </svg>
                                <span class="btn-text">Add picture</span>
                            </label>

                            <div id="file-chosen-text" class="file-chosen-text">No file chosen</div>
                        </div>

                        <button type="submit" class="submit-review-btn">Submit Review</button>
                    </form>
                </div>
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

<script>
  //Show the clicked tab
  function openTab(evt, tabName) {
    let tabPanes = document.querySelectorAll('.tab-pane');
    tabPanes.forEach(function(pane) {
        pane.classList.remove('active');
    });

    let tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(function(btn) {
        btn.classList.remove('active');
    });

    document.getElementById(tabName).classList.add('active');
    
    evt.currentTarget.classList.add('active');
}

// Allows to click to switch between various images
document.querySelectorAll('.thumb img').forEach(img => {
    img.addEventListener('click', function() {
        document.querySelector('.product-image').src = this.src;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('review-media');
    const fileText = document.getElementById('file-chosen-text');

    if(fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 1) {
                fileText.textContent = `Files chosen: ${this.files.length}`;
            } else if (this.files && this.files.length === 1) {
                fileText.textContent = this.files[0].name;
            } else {
                fileText.textContent = 'No file chosen';
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const product = {
        stock_status: "{{ $product->stock_status ?? 'out_of_stock' }}",
        stock_quantity: parseInt("{{ $product->stock_quantity ?? 0 }}", 10) || 0
    };

    const isInStock = product.stock_status === 'in_stock' || product.stock_quantity > 0;
    const isLowStock = product.stock_quantity > 0 && product.stock_quantity < 5;

    let badgeText;
    let badgeClass;

    if (!isInStock) {
        badgeText = 'Out of Stock';
        badgeClass = 'badge-out-of-stock';
    } else if (isLowStock) {
        badgeText = 'Low Stock';
        badgeClass = 'badge-low-stock';
    } else {
        badgeText = 'In Stock';
        badgeClass = 'badge-in-stock';
    } 

    const stockBox = document.getElementById('dynamic-stock-box');
    if (stockBox) {
        stockBox.innerHTML = `<span class="stock-badge ${badgeClass}">${badgeText}</span>`;
    }
});
</script>