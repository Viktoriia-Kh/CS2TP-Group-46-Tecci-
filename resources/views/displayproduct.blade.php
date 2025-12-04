<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="style.css" />
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
          <li><a href="/" >Home</a></li> <!--class="active" marks the Current Page-->
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="displayproduct"class="active">Products</a></li>
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
          <button class="tab-button" data-category="pcs">PCs</button>
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
          <li><a href="display-product">Products</a></li>
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
      <a href="/product/${product.id}">
          <div class="product-image-placeholder"></div>
          <div class="product-item-info">
              <h4>${product.name}</h4>
              <p class="product-item-price">£${product.price.toFixed(2)}</p>
              <button class="add-to-cart-quick">Add to Cart</button>
            </div>
          </div>
      </a>
    `;

      grid.appendChild(productCard);
    });
  }

  // Initialize display
  displayProducts();
</script>