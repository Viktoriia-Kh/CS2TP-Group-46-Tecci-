<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  {{-- ADDED: CSRF Token for future POST requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="common-style.css" />
  <link rel="stylesheet" href="displaystyle.css" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  {{-- ADDED: Toast Notification Styles --}}
  <style>
    /* Toast Container - Positioned at top right */
    #toast-container {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        pointer-events: none;
    }

    /* Individual Toast Notification */
    .toast-notification {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        padding: 16px 20px;
        min-width: 320px;
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        transform: translateX(120%);
        animation: slideIn 0.4s ease forwards;
        pointer-events: auto;
        transition: transform 0.4s ease, opacity 0.4s ease, margin-top 0.4s ease;
    }

    @keyframes slideIn {
        to { transform: translateX(0); }
    }

    /* Toast Icon */
    .toast-icon {
        font-size: 24px;
        flex-shrink: 0;
    }

    /* Toast Content */
    .toast-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .toast-title {
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .toast-message {
        font-size: 13px;
        color: #666;
    }

    /* Toast Product Image */
    .toast-product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    /* Progress Bar */
    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 100%;
        animation: shrink 3s linear forwards;
    }

    @keyframes shrink {
        to { width: 0%; }
    }
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
          <li><a href="/" >Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="displayproduct"class="active">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a> <!--fa-heart is a Heart Icon linked from Font Awesome-->
        
        {{-- UPDATED: Basket icon with dynamic badge count from database --}}
        <a href="{{ route('basket.index') }}" class="cart-icon-wrapper">
            <i class="fa-solid fa-cart-shopping"></i>
            
            @php
                use App\Models\BasketItem;
                
                // Get total quantity from database
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
            <input type="range" min="0" max="2000" value="2000" class="price-slider">
            <div class="price-range-display">
              <span>£0</span> - <span>£2000</span>
            </div>
          </div>

          <div class="filter-group">
            <h4>Condition</h4>
            <label class="checkbox-label">
              <input type="checkbox" value="new"> New
            </label>
            <label class="checkbox-label">
              <input type="checkbox" value="used"> Used
            </label>
            <label class="checkbox-label">
              <input type="checkbox" value="refurbished"> Refurbished
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
          <button class="tab-button" data-category="phones">Phones</button>
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

<script>

// Product data with categories and details
    const allProducts = @json($productsForJs);


  let currentCategory = "all";
  let currentSortOption = "featured";
  let priceRange = 2000;
  let selectedConditions = [];

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
    selectedConditions = Array.from(document.querySelectorAll(".checkbox-label input[type='checkbox']:checked"))
      .map(cb => cb.value);
    displayProducts();
  });

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
        sorted.sort((a, b) => b.id - a.id); // Placeholder for rating
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



    productCard.innerHTML = `
      <a href="/product/${product.id}" class="product-link">
        <div class="product-image-placeholder">
          <img src="${product.image_url}" alt="${product.name}">
        </div>
        <div class="product-item-info">
          <h4>${product.name}</h4>
          <p class="product-item-price">£${product.price.toFixed(2)}</p>
          <a href="/add-to-basket/${product.id}" class="add-to-cart-quick">Add to Cart</a>
        </div>
      </a>
    `;

      grid.appendChild(productCard);
    });
  }

  {{-- ADDED: Toast Notification Function --}}
  function showToast(title, message, type = 'success', imageUrl = null) {
    // Find or create toast container
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      document.body.appendChild(container);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification'; 
    
    const color = type === 'success' ? '#2ecc71' : '#e74c3c';
    const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
    const imageHtml = imageUrl ? `<img src="${imageUrl}" class="toast-product-image" alt="Product">` : '';
    
    toast.style.borderLeft = `5px solid ${color}`;
    toast.innerHTML = `
      <div class="toast-icon" style="color: ${color}">${icon}</div>
      <div class="toast-content">
        <span class="toast-title" style="color: #333">${title}</span>
        <span class="toast-message">${message}</span>
      </div>
      ${imageHtml}
      <div class="toast-progress" style="background-color: ${color}"></div>
    `;
    
    // Add to container
    container.appendChild(toast);
    
    // Remove after animation
    setTimeout(() => {
      toast.style.transform = "translateX(120%)";
      toast.style.opacity = "0";
      
      setTimeout(() => {
        toast.style.marginTop = `-${toast.offsetHeight + 15}px`; 
        setTimeout(() => toast.remove(), 400); 
      }, 400); 
    }, 3000);
  }

  {{-- ADDED: Show toast on page load if success message exists --}}
  @if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
      const message = "{{ session('success') }}";
      showToast("Success", message, "success");
    });
  @endif

  // Initialize display
  displayProducts();
</script>
