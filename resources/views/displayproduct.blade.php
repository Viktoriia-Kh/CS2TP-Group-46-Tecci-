<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  {{-- CSRF Token for AJAX requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="common-style.css" />
  <link rel="stylesheet" href="displaystyle.css" />
    <link rel="stylesheet" href="{{ asset('Dark-Mode.css')}}">
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('chatbot.css') }}">

  {{-- Toast Notification Styles (Matched to Basket Page) --}}
  <style>
    /* Toast Container - Positioned to match basket page */
    #toast-container {
        position: fixed;
        top: 140px; 
        right: 30px; 
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        pointer-events: none;
    }

    /* Individual Toast Notification - Made significantly larger */
    .toast-notification {
        background: white;
        min-width: 380px; /* Increased from 320px */
        padding: 20px 25px; /* Increased padding */
        border-radius: 12px; 
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); /* Stronger shadow */
        display: flex;
        align-items: center;
        gap: 20px; /* More space between image and text */
        position: relative;
        overflow: hidden;
        pointer-events: auto;
        
        /* Snappy bounce animation */
        transform: translateX(120%);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.4s ease;
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    /* Toast Icon */
    .toast-icon {
        font-size: 32px; /* Larger icon */
        flex-shrink: 0;
    }

    /* Toast Content */
    .toast-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px; /* More space between title and message */
    }

    .toast-title {
        font-weight: 700;
        font-size: 16px; /* Increased from 14px */
        color: #111827; /* Darker text */
    }

    .toast-message {
        font-size: 14px; /* Increased from 13px */
        color: #4b5563;
        font-weight: 500;
    }

    /* Toast Product Image */
    .toast-product-image {
        width: 60px; /* Increased from 50px */
        height: 60px; /* Increased from 50px */
        object-fit: cover;
        border-radius: 8px; 
        flex-shrink: 0;
        border: 1px solid #e5e7eb;
    }

    /* Progress Bar */
    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 5px; /* Thicker bar */
        width: 100%;
        animation: shrink 3s linear forwards;
    }

    @keyframes shrink {
        to { width: 0%; }
    }
  </style>

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
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/" >Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="displayproduct"class="active">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
        
        {{-- Basket icon with dynamic badge count from database --}}
        <a href="{{ route('basket.index') }}" class="cart-icon-wrapper">
            <i class="fa-solid fa-cart-shopping"></i>
            
            @php
                use App\Models\BasketItem;
                
                // Get total quan`tity from database
                if (Auth::check()) {
                    // For logged-in users
                    $basketCount = BasketItem::where('user_id', Auth::id())->sum('quantity');
                } else {
                    // For guests
                    $basketCount = BasketItem::where('session_id', session()->getId())->sum('quantity');
                }
            @endphp
            
            {{-- Only show badge if there are items --}}
            @if($basketCount > 0)
                <span class="cart-badge">{{ $basketCount }}</span>
            @endif
        </a>
        
        <a href="login"><i class="fa-regular fa-user"></i></a> <!--fa-user is a User Icon linked from Font Awesome-->

        <!--Added A Dark/Light Mode Toggle Button-->
                <button type="button" class="theme-toggle" id="themeToggle" aria-label="Switch to dark mode">
                    <i class="fa-solid fa-moon"></i>
                    <!--fa-moon is a Moon Icon linked from Font Awesome-->
                    <!--class="theme-toggle" lets us style the button using CSS-->
                    <!--id="themeToggle" allows us to use this id in JavaScript-->
                </button>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="products-page">
    <div class="products-container">
      <!-- LEFT SIDEBAR - FILTER -->
      <aside class="filters-sidebar">
        <div class="filter-section">
          <h3>Filter</h3>
          
          <!-- Search Bar -->
          <div class="search-box">
            <input type="text" placeholder="Search products..." class="search-input">
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>

          <!-- Filter Categories  -->
          <div class="filter-group">
            <h4>Price Range</h4>
            <input type="range" min="0" max="1000" value="1000" class="price-slider">
            <div class="price-range-display">
              <span>£0</span> - <span>£1000</span>
            </div>
          </div>

          <div class="filter-group">
            <h4>Condition</h4>
            <label class="checkbox-label">
              <input type="checkbox" class="condition-filter" value="new"> New
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="condition-filter" value="used">
 Used
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="condition-filter" value="refurbished"> Refurbished
            </label>
          </div>
          <div class="filter-group">
            <h4>Rating</h4>
            <label class="checkbox-label">
              <input type="checkbox" class="rating-filter" value="5">
 5 Stars ★★★★★
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="rating-filter" value="4"> 4 Stars ★★★★☆
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="rating-filter" value="3"> 3 Stars ★★★☆☆
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="rating-filter" value="2"> 2 Stars ★★☆☆☆
            </label>
            <label class="checkbox-label">
              <input type="checkbox" class="rating-filter" value="1"> 1 Star ★☆☆☆☆
            </label>
          </div>

          <button class="confirm-filter-btn">Apply Filters</button>
        </div>
      </aside>

      <!-- RIGHT CONTENT AREA -->
      <div class="products-content">
        <!-- CATEGORY TABS -->
        <div class="category-tabs">
          <button class="tab-button active" data-category="all">All Products</button>
          <button class="tab-button" data-category="desktops">PCs</button>
          <button class="tab-button" data-category="laptops">Laptops</button>
          <button class="tab-button" data-category="phones">Smartphones</button>
          <button class="tab-button" data-category="tablets">Tablets</button>
          <button class="tab-button" data-category="accessories">Accessories</button>
          
          <!-- Sort Dropdown -->
          <div class="sort-container">
            <select class="sort-dropdown">
              <option value="featured">Sort by: Featured</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="newest">Newest</option>
              <option value="rating">Top Rated</option>
            </select>
          </div>
        </div>

        <!-- FEATURED PRODUCTS GRID -->
        <div class="featured-items-section">
          <div class="featured-grid">
          </div>
        </div>
      </div>
    </div>
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
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="displayproduct">Products</a></li>
          <li><a href="{{ route('basket.index') }}">Basket</a></li>
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

  

</body>

</html>
<script src="Dark-Mode-Theme.js"></script>
<script>

// Product data with categories and details
const allProducts = @json($productsForJs);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  const urlParams = new URLSearchParams(window.location.search);
  const categoryFromUrl = urlParams.get('category');
  let currentCategory = "all";

  if (categoryFromUrl && ["all", "desktops", "laptops", "phones", "tablets", "accessories"].includes(categoryFromUrl)) {
      currentCategory = categoryFromUrl;
      
      // Update the active state of the buttons on page load
      document.addEventListener("DOMContentLoaded", () => {
          document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
          const activeButton = document.querySelector(`.tab-button[data-category="${currentCategory}"]`);
          if (activeButton) activeButton.classList.add("active");
      });
  }

  let currentSortOption = "featured";
  let priceRange = 5000;
  let selectedConditions = [];
  let selectedRatings = [];

// Category tab functionality
document.querySelectorAll(".tab-button").forEach(button => {
  button.addEventListener("click", (e) => {
    document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
    e.target.classList.add("active");
    currentCategory = e.target.dataset.category;
    displayProducts();
  });
});

// Sort dropdown functionality
document.querySelector(".sort-dropdown").addEventListener("change", (e) => {
  currentSortOption = e.target.value;
  displayProducts();
});

// Price range slider
document.querySelector(".price-slider").addEventListener("input", (e) => {
  priceRange = e.target.value;
  document.querySelectorAll(".price-range-display span")[1].textContent = "£" + priceRange;
});

// Search functionality
document.querySelector(".search-input").addEventListener("input", (e) => {
  const searchTerm = e.target.value.toLowerCase();
  filterAndDisplayProducts(searchTerm);
});

  // Apply filters button
document.querySelector(".confirm-filter-btn").addEventListener("click", () => {
  selectedConditions = Array.from(document.querySelectorAll(".condition-filter:checked"))
    .map(cb => cb.value);

  selectedRatings = Array.from(document.querySelectorAll(".rating-filter:checked"))
    .map(cb => Number(cb.value));

  displayProducts();
});

// Applies star review functionalltiy 
  function renderStars(rating) {
    const rounded = Math.round(rating || 0);
    return '★'.repeat(rounded) + '☆'.repeat(5 - rounded);
}

// Filter products based on criteria
function filterProducts(searchTerm = "") {
  let filtered = allProducts;

  // Filter by category
  if (currentCategory !== "all") {
    filtered = filtered.filter(p => p.category === currentCategory);
  }

  // Filter by price range
  filtered = filtered.filter(p => p.price <= priceRange);

  // Filter by condition
  if (selectedConditions.length > 0) {
    filtered = filtered.filter(p => selectedConditions.includes(p.condition));
  }

    // Filter by search term
    if (searchTerm) {
      filtered = filtered.filter(p => p.name.toLowerCase().includes(searchTerm));
    }

    // Filter by condition
    if (selectedConditions.length > 0) {
      filtered = filtered.filter(p => selectedConditions.includes(p.condition));
    }

    // Filter by rating
    if (selectedRatings.length > 0) {
      filtered = filtered.filter(p => {
        const roundedRating = Math.round(Number(p.avg_rating) || 0);
        return selectedRatings.includes(roundedRating);
      });
    }

  return filtered;
}

  // Sort products
  function sortProducts(products) {
    const sorted = [...products];
    
    switch(currentSortOption) {
      case "price-low":
        sorted.sort((a, b) => a.price - b.price);
        break;
      case "price-high":
        sorted.sort((a, b) => b.price - a.price);
        break;
      case "newest":
        sorted.sort((a, b) => b.id - a.id);
        break;
      case "rating":
        sorted.sort((a, b) => b.avg_rating - a.avg_rating);
        break;
      case "featured":
      default:
        // Keep original order
        break;
    }
    
    return sorted;
  }

// Display products
function displayProducts() {
  const filtered = filterProducts();
  const sorted = sortProducts(filtered);
  renderProducts(sorted);
}

// Filter and display with search
function filterAndDisplayProducts(searchTerm) {
  const filtered = filterProducts(searchTerm);
  const sorted = sortProducts(filtered);
  renderProducts(sorted);
}

// AJAX Add to Basket (NO PAGE REFRESH!)
function addToBasketAjax(productId, productName, productImage, quantity = 1) {
  fetch(`/add-to-basket/${productId}?quantity=${quantity}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'X-Requested-With': 'XMLHttpRequest', // CRITICAL: Tells Laravel this is AJAX
      'Accept': 'application/json'          // CRITICAL: Tells Laravel we want JSON back
    },
    body: JSON.stringify({ quantity: quantity })
  })
  .then(res => {
      if (!res.ok) throw new Error('Network response was not ok');
      return res.json();
  })
  .then(data => {
    if (data.success) {
      // Show toast with product image
      const message = quantity > 1 
        ? `${quantity} × ${productName} added to your basket!`
        : `${productName} added to your basket!`;
      
      showToast("Added to Basket", message, "success", productImage);
      
      // Update header badge
      const cartBadge = document.querySelector('.cart-badge');
      if (cartBadge) {
        cartBadge.innerText = data.totalQty;
        cartBadge.style.display = 'flex';
      } else {
        // Create badge if it doesn't exist
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

// Render products to the DOM
function renderProducts(products) {
  const grid = document.querySelector(".featured-grid");
  grid.innerHTML = "";

  if (products.length === 0) {
    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">No products found</p>';
    return;
  }

  products.forEach(product => {
    const productCard = document.createElement("div");
    productCard.className = "product-card-item";

const isInStock = product.stock_status === 'in_stock' || product.stock_quantity > 0;
    const isLowStock = product.stock_quantity > 0 && product.stock_quantity < 5;

    let badgeText;
    let badgeClass;

    // Check the stock states in order
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

    // Escaping quotes for JS function call
    const safeProductName = product.name.replace(/'/g, "\\'");

    productCard.innerHTML = `
      <div onclick="window.location.href='/product/${product.id}'" class="product-link" style="text-decoration: none; cursor: pointer;">
        <div class="stock-badge ${badgeClass}">${badgeText}</div>
        <div class="product-image-placeholder">
          <img src="${product.image_url}" alt="${product.name}">
        </div>
        <div class="product-item-info">
          <p class="product-item-name">${product.name}</p>
          ${renderStars(product.avg_rating)} (${product.review_count || 0})
          <p class="product-short-desc">${product.description || 'Smart tech device perfect for students.'}</p>
          <p class="product-item-price">£${product.price.toFixed(2)}</p>
          
          <div class="cart-action-group" onclick="event.stopPropagation();">
            <input type="number" id="qty-${product.id}" class="qty-input" value="1" min="1" max="99" title="Quantity">
            <button type="button" class="add-to-cart-quick" onclick="addToBasketAjax(${product.id}, '${safeProductName}', '${product.image_url}', document.getElementById('qty-${product.id}').value)">Add to Basket</button>
          </div>
        </div>
      </div>
    `;

        grid.appendChild(productCard);
      });
    }

// Toast Notification Function (Synced with Basket style)
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
  
  // Slide In using the new class (matches the basket's cubic-bezier bounce)
  setTimeout(() => toast.classList.add('show'), 10);
  
  // Slide Out & Delete
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400); 
  }, 3000);
}

// Initialise display
displayProducts();
</script>