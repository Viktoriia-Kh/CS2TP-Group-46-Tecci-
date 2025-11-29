<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Affordable Tech for Students</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="style.css" />
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
        <span class="logo-text">TECCI</span>
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
            <!-- Product Card 1 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Lorem Ipsum Device</h4>
                <p class="product-item-price">£599.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Dolor Sit Amet Pro</h4>
                <p class="product-item-price">£1,299.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Consectetur Ultra</h4>
                <p class="product-item-price">£449.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Adipiscing Tech Max</h4>
                <p class="product-item-price">£899.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>

            <!-- Product Card 5 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Elit Gadget Plus</h4>
                <p class="product-item-price">£349.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>

            <!-- Product Card 6 -->
            <div class="product-card-item">
              <div class="product-image-placeholder"></div>
              <div class="product-item-info">
                <h4>Sed Do Device</h4>
                <p class="product-item-price">£749.99</p>
                <button class="add-to-cart-quick">Add to Cart</button>
              </div>
            </div>
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