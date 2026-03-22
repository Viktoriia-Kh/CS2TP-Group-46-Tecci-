<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Shared Admin CSS -->
 
  <link rel="stylesheet" href="admin-inventory-style.css" />
  <!--Google Font-->
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
    <div class="container nav-container">
        <!--The Logo and Menu Button are now grouped together on the left-->
        <div class="header-left-group">

      <!--Logo-->
      <a href="/" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
      </a>

      <!--ADMIN HEADER CONTROLS (MENU + SEARCH)-->
      
        <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
          <!--id="menuBtn" connects to the JS, for it to work-->
          <i class="fa-solid fa-bars"></i> <!--fa-bars is a Menu Icon linked from Font Awesome-->
        </button>
      </div>

      <div class="admin-header-spacer"></div>

      <!--Icons-->
      <div class="nav-icons admin-top-icons">
        <a href="TP2_Notifications.html" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>  <!--fa-bell is a Bell Icon linked from Font Awesome-->
        <a href="TP2_Messages.html" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>  <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
        <a href="/" aria-label="Home"><i class="fa-solid fa-house"></i></a>  <!--fa-house is a House Icon linked from Font Awesome-->
      </div>

    </div>
  </header>

  <!--MAIN ADMIN LAYOUT-->
  <main class="admin-shell"> <!--This is a layout wrapper which contains the Sidebar and Content Area-->
    <!--SIDEBAR-->
    <aside class="admin-sidebar" id="adminSidebar"> <!--aside represents the secondary content, side navigation-->
      <div class="admin-profile">
        <div class="profile-avatar">
          <i class="fa-solid fa-user-tie"></i>  <!--fa-user-tie is a User/Avatar Icon linked from Font Awesome-->
        </div>
        <div class="profile-meta"> <!--Using this will allow the Avatar/Profile to stay visible while hiding the text, which is all done in CSS-->
          <p class="profile-name">Full Name</p>
          <p class="profile-role">Admin</p>
        </div>
      </div>

      <a class="sidebar-logout" href="/">LOGOUT</a>

      <!--NAV TEXT (SIDEBAR) + ICONS ON THE RIGHT-->
      <nav class="admin-nav">
        <a  href="/admin-dashboard">
          <span class="nav-text">Dashboard</span> <!--span will allow the text in the Sidebar to be hidden when it collapses, which is done in CSS-->
          <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span> <!--fa-chart-line is a Chart Icon linked from Font Awesome-->
        </a>

        <a href="/admin-orders">
          <span class="nav-text">Orders</span>
          <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span> <!--fa-receipt is a Receipt Icon linked from Font Awesome-->
        </a>

        

        <a class="active" href="admin-inventory">
          <span class="nav-text">Inventory</span>
          <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span> <!--fa-warehouse is a Warehouse Icon linked from Font Awesome-->
        </a>

        <a href="/admin-customers">
          <span class="nav-text">Customers</span>
          <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span> <!--fa-user-group is a User (Group) Icon linked from Font Awesome-->
        </a>

        <a href="/admin-settings">
          <span class="nav-text">Admin Settings</span>
          <span class="nav-ico"><i class="fa-solid fa-gear"></i></span> <!--fa-gear is a Gear/Settings Icon linked from Font Awesome-->
        </a>
      </nav>
    </aside>
    
    <!--PAGE CONTENT (THIS PART CHANGES)-->
    
    <section class="admin-content">
        <div class="admin-content-inner">
            <!-- PAGE TITLE -->
            <div class="dash-title">
               <p class="dash-kicker">Hello Admin</p>
               <h1>Inventory</h1>
            </div>

            <!--The Search Bar has been moved under the page heading-->  
            <div class="inventory-search-row"> <!--This is a wrapper for styling purpose of the Search Bar-->
              <div class="page-search-wrap">
                <!--fa-magnifying-glass is a Magnifying Glass Icon linked from Font Awesome-->
                <i class="fa-solid fa-magnifying-glass"></i> <!--This creates a Magnifying Glass Icon which is just purely visual for now-->
                <input type="text" id="searchInput" placeholder="Search" aria-label="Search (visual only)" oninput="applyFilters()">
             </div>
            </div>

            <button class="btn-add-product" onclick="openAddModal()">
                    <i class="fa-solid fa-plus"></i> Add New Product
                </button>
            <div class="category-tabs">
                <button class="tab-button active" data-category="all">All Products</button>
                <button class="tab-button" data-category="desktops">PCs</button>
                <button class="tab-button" data-category="laptops">Laptops</button>
                <button class="tab-button" data-category="phones">Smartphones</button>
                <button class="tab-button" data-category="tablets">Tablets</button>
                <button class="tab-button" data-category="accessories">Accessories</button>
            </div>

            <div class="inventory-controls">
            
            <div class="filter-group">
                <label for="filterStatus">Status:</label>
                <select id="filterStatus" class="filter-input" onchange="applyFilters()">
                    <option value="all">All Statuses</option>
                    <option value="in_stock">In Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Price (£):</label>
                <input type="number" id="priceMin" class="filter-input-small" placeholder="Min" min="0" oninput="applyFilters()">
                <span>-</span>
                <input type="number" id="priceMax" class="filter-input-small" placeholder="Max" min="0" oninput="applyFilters()">
            </div>

            <div class="filter-group">
                <label>Stock:</label>
                <input type="number" id="stockMin" class="filter-input-small" placeholder="Min" min="0" oninput="applyFilters()">
                <span>-</span>
                <input type="number" id="stockMax" class="filter-input-small" placeholder="Max" min="0" oninput="applyFilters()">
            </div>

            <button onclick="resetFilters()" class="btn-reset">
                <i class="fa-solid fa-rotate-right"></i> Reset
            </button>

        </div>

        
        <!-- PAGE CONTENT GOES HERE -->
        <div class="featured-items-section">
            <div class="featured-grid">
            </div>
        </div>
        
    </section>

</main>
<!-- EDIT PRODUCT MODAL -->
<div id="editProductModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Product</h2>
            <button class="close-modal-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editProductForm">
            <input type="hidden" id="edit-product-id">

            <div class="form-group">
                <label for="edit-name">Product Name</label>
                <input type="text" id="edit-name" name="name" required>
            </div>

            <div class="form-group">
                <label for="edit-category">Category</label>
                <select id="edit-category" name="category" class="filter-input" style="width: 100%;" required>
                    <option value="desktops">PCs</option>
                    <option value="laptops">Laptops</option>
                    <option value="phones">Phones</option>
                    <option value="tablets">Tablets</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>

            <div class="form-group">
                <label for="edit-price">Price (£)</label>
                <input type="number" id="edit-price" name="price" step="0.01" required> <!-- Now we can add decimals -->
            </div>

            <div class="form-group">
                <label for="edit-stock">Stock Quantity</label>
                <input type="number" id="edit-stock" name="stock_quantity" required>
            </div>

            <div class="form-group">
                <label for="edit-desc">Description</label>
                <textarea id="edit-desc" name="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Technical Specifications</label>
                <div id="edit-specs-container" class="specs-container">
                    </div>
                <button type="button" class="btn-add-spec" onclick="addEditSpecRow()">
                    <i class="fa-solid fa-plus"></i> Add Specification
                </button>
            </div>

            <div class="media-upload-group">
                <input type="file" id="edit-product-image" name="image" accept="image/*" class="hidden-file-input">
                <label for="edit-product-image" class="add-media-btn">
                    <svg class="camera-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23 19V5H19L17.17 3H6.83L5 5H1V19H23ZM12 8C14.21 8 16 9.79 16 12C16 14.21 14.21 16 12 16C9.79 16 8 14.21 8 12C8 9.79 9.79 8 12 8Z" fill="#3B82F6"/>
                    </svg>
                    <span class="btn-text">Change picture</span>
                </label>
                <div id="edit-file-chosen" class="file-chosen-text">No new file chosen</div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<!-- Add product modal -->
<div id="addProductModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Product</h2>
            <button class="close-modal-btn" onclick="closeAddModal()">&times;</button>
        </div>
        <form id="addProductForm" onsubmit="submitNewProduct(event)">
            <div class="form-group">
                <label for="add-name">Product Name</label>
                <input type="text" id="add-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="add-category">Category</label>
                <select id="add-category" name="category" class="filter-input" style="width: 100%;" required>
                    <option value="desktops">PCs</option>
                    <option value="laptops">Laptops</option>
                    <option value="phones">Phones</option>
                    <option value="tablets">Tablets</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="add-price">Price (£)</label>
                <input type="number" id="add-price" name="price" step="1" required>
            </div>
            <div class="form-group">
                <label for="add-stock">Stock Quantity</label>
                <input type="number" id="add-stock" name="stock_quantity" required>
            </div>
            <div class="form-group">
                <label for="add-desc">Description</label>
                <textarea id="add-desc" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Technical Specifications</label>
                <div id="specs-container" class="specs-container">
                    <div class="spec-row">
                        <input type="text" name="spec_names[]" placeholder="Spec (e.g. RAM)">
                        <input type="text" name="spec_values[]" placeholder="Value (e.g. 16GB)">
                        <button type="button" class="btn-remove-spec" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                </div>
                <button type="button" class="btn-add-spec" onclick="addSpecRow()">
                    <i class="fa-solid fa-plus"></i> Add Specification
                </button>
            </div>
            <div class="media-upload-group">
                <input type="file" id="product-image" name="image" accept="image/*" class="hidden-file-input">
                
                <!-- now matches pathj -->
                <label for="product-image" class="add-media-btn">
                    <svg class="camera-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23 19V5H19L17.17 3H6.83L5 5H1V19H23ZM12 8C14.21 8 16 9.79 16 12C16 14.21 14.21 16 12 16C9.79 16 8 14.21 8 12C8 9.79 9.79 8 12 8Z" fill="#3B82F6"/>
                    </svg>
                    <span class="btn-text">Add picture</span>
                </label>
                
                <div id="file-chosen-text" class="file-chosen-text">No file chosen</div>
                </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancel</button>
                <button type="submit" class="btn-save">Add Product</button>
            </div>
        </form>
    </div>
</div>
<!--FOOTER (REUSABLE)-->
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
                <li><a href="/basket">Basket</a></li>
                <li><a href="/account">My Account</a></li>
            </ul>
        </div>
        
        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="contact-list">
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    <!--fa-loocation-dot is a Location Icon linked from Font Awesome-->
                    <span>0121 555 0198</span><br><br>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
                    <span>Tecci_Queries@net.com</span><br><br>
                </li>
                <li>
                    <i class="fa-regular fa-envelope"></i>
                    <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
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

<script src="admin-dashboard.js"></script>
<script>
    const allProducts = @json($productsForJs ?? []);
    let activeCategory = "all";
    document.querySelectorAll(".tab-button").forEach(button => {
        button.addEventListener("click", (e) => {
            document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
            
            e.target.classList.add("active");

            activeCategory = e.target.dataset.category;
            
            
            applyFilters();
        });
    });
    
    // Filters
    function applyFilters() {
        // Getting data
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('filterStatus').value;
        const priceMin = parseFloat(document.getElementById('priceMin').value) || 0;
        const priceMax = parseFloat(document.getElementById('priceMax').value) || Infinity;
        const stockMin = parseInt(document.getElementById('stockMin').value) || 0;
        const stockMax = parseInt(document.getElementById('stockMax').value) || Infinity;

        // Filter
        const filteredProducts = allProducts.filter(product => {
            // Search check
            const nameMatches = product.name.toLowerCase().includes(searchTerm);
            const passesSearch = nameMatches;

            // Category check
            const passesCategory = (activeCategory === "all") || (product.category === activeCategory);

            // Stock check
            const isInStock = product.stock_status === 'in_stock' || product.stock_quantity > 0;
            let passesStatus = true;
            if (status === 'in_stock') passesStatus = isInStock;
            if (status === 'out_of_stock') passesStatus = !isInStock;

            // Price check
            const passesPrice = product.price >= priceMin && product.price <= priceMax;

            // Quantity check
            const passesStock = product.stock_quantity >= stockMin && product.stock_quantity <= stockMax;

            return passesSearch && passesCategory && passesStatus && passesPrice && passesStock;
        });

        renderAllProducts(filteredProducts);
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterStatus').value = 'all';
        document.getElementById('priceMin').value = '';
        document.getElementById('priceMax').value = '';
        document.getElementById('stockMin').value = '';
        document.getElementById('stockMax').value = '';
        
        renderAllProducts(allProducts);
    }

    function renderAllProducts(products) {
        const grid = document.querySelector(".featured-grid");
        
        grid.innerHTML = "";

        if (products.length === 0) {
            grid.innerHTML = '<p style="padding: 20px;">No products found in database.</p>';
            return;
        }

        products.forEach(product => {
            const productCard = document.createElement("div");
            productCard.className = "product-card-item";

            const isInStock = product.stock_status === 'in_stock' || product.stock_quantity > 0;
            const badgeText = isInStock ? 'In Stock' : 'Out of Stock';
            const badgeClass = isInStock ? 'badge-in-stock' : 'badge-out-of-stock';

            productCard.innerHTML = `
                <div onclick="window.location.href='/product/${product.id}'" class="product-link" style="text-decoration: none;">
                    <div class="stock-badge ${badgeClass}">${badgeText}</div>
                    <div class="product-image-placeholder">
                        <img src="${product.image_url}" alt="${product.name}">
                    </div>
                    <div class="product-item-info">
                        <p class="product-item-name">${product.name}</p>
                            <!-- Placeholder stars -->
                        <p class="star-rating">★★★★☆</p>
                        <p class="product-short-desc">${product.description || 'Smart tech device perfect for students.'}</p>
                        <p class="product-item-price">£${product.price.toFixed(2)}</p>
                        <p class="product-item-stock">Stock: ${product.stock_quantity}</p>
                        <div class="card-action-buttons">
                            <button class="edit-btn" onclick="event.stopPropagation(); openEditModal(${product.id})">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="event.stopPropagation(); deleteProduct(${product.id})">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;
            grid.appendChild(productCard);
        });
    }


    // Edit window open logic
    function openEditModal(productId) {
        const product = allProducts.find(p => p.id === productId);
        if (!product) return;

        document.getElementById('edit-product-id').value = product.id;
        document.getElementById('edit-name').value = product.name;
        document.getElementById('edit-category').value = product.category;
        document.getElementById('edit-price').value = product.price;
        document.getElementById('edit-stock').value = product.stock_quantity;
        document.getElementById('edit-desc').value = product.description || '';

        // Load current technical specs into the edit modal
        const specsContainer = document.getElementById('edit-specs-container');
        specsContainer.innerHTML = '';

        if (product.specs && product.specs.length > 0) {
            product.specs.forEach(spec => {
                addEditSpecRow(spec.spec_name, spec.spec_value);
            });
        } else {
            addEditSpecRow();
        }

        document.getElementById('editProductModal').style.display = 'flex';
    }

    // Close the edit window
    function closeEditModal() {
        document.getElementById('editProductModal').style.display = 'none';
    }

    // ADD PRODUCT LOGIC 
    function openAddModal() {
        document.getElementById('addProductForm').reset();
        document.getElementById('addProductModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addProductModal').style.display = 'none';
    }

    // ADD PRODUCT LOGIC (NOW SAVES TO DATABASE)
    async function submitNewProduct(event) {
        event.preventDefault(); // Stop page refresh

        // Getting form values
        const name = document.getElementById('add-name').value;
        const category = document.getElementById('add-category').value;
        const price = document.getElementById('add-price').value;
        const stock = document.getElementById('add-stock').value;
        const description = document.getElementById('add-desc').value;
        const specNames = Array.from(document.querySelectorAll('input[name="spec_names[]"]')).map(input => input.value);
        const specValues = Array.from(document.querySelectorAll('input[name="spec_values[]"]')).map(input => input.value);

        // File input 
        const fileInput = document.getElementById('product-image');

        // Send image + data together
        const formData = new FormData();
        formData.append('name', name);
        formData.append('category', category);
        formData.append('price', price);
        formData.append('stock_quantity', stock);
        formData.append('description', description);

        // Add specs to form data
        specNames.forEach((name, index) => {
            formData.append('spec_names[]', name);
            formData.append('spec_values[]', specValues[index] || '');
        });

        // If image selected → add it
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        try {
            // Sending data to Laravel backend
            const response = await fetch('/admin-inventory/products', {
                method: 'POST',
                headers: {
                    // CSRF token for Laravel security
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            });

            if (response.ok) {
                // Close modal + refresh page to show new product
                closeAddModal();
                location.reload();
            } else {
                const errorText = await response.text();
                console.error("Server response:", errorText);
                alert("Error adding product. Check console.");
            }

        } catch (error) {
            console.error("Add product failed:", error);
            alert("Something went wrong.");
        }
    }

    //  DELETE PRODUCT LOGIC
    // DELETE PRODUCT (REAL DATABASE DELETE)
    async function deleteProduct(productId) {
        if (!confirm("Are you sure you want to delete this product?")) {
            return;
        }

        try {
            const response = await fetch(`/admin-inventory/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    // CSRF protection
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                // Refresh page
                location.reload();
            } else {
                const errorText = await response.text();
                console.error(errorText);
                alert("Failed to delete product.");
            }

        } catch (error) {
            console.error(error);
            alert("Error deleting product.");
        }
    }

    // Adding images in add product
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('product-image');
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

    function addSpecRow() {
        const container = document.getElementById('specs-container');
        const row = document.createElement('div');
        row.className = 'spec-row'; 
        row.innerHTML = `
            <input type="text" name="spec_names[]" placeholder="Spec name">
            <input type="text" name="spec_values[]" placeholder="Value">
            <button type="button" class="btn-remove-spec" onclick="this.parentElement.remove()">&times;</button>
        `;
        container.appendChild(row);
    }

    function addEditSpecRow(name = '', value = '') {
        const container = document.getElementById('edit-specs-container');
        const row = document.createElement('div');
        row.className = 'spec-row';
        row.innerHTML = `
            <input type="text" name="edit_spec_names[]" value="${name}" placeholder="Spec name">
            <input type="text" name="edit_spec_values[]" value="${value}" placeholder="Value">
            <button type="button" class="btn-remove-spec" onclick="this.parentElement.remove()">&times;</button>
        `;
        container.appendChild(row);
    }

    // EDIT PRODUCT (REAL DATABASE UPDATE)
    document.getElementById('editProductForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Stop page refresh

        const productId = document.getElementById('edit-product-id').value;

        // Getting edited values
        const formData = new FormData();
        formData.append('name', document.getElementById('edit-name').value);
        formData.append('category', document.getElementById('edit-category').value);
        formData.append('price', document.getElementById('edit-price').value);
        formData.append('stock_quantity', document.getElementById('edit-stock').value);
        formData.append('description', document.getElementById('edit-desc').value);

        // Getting edited specs
        const editSpecNames = Array.from(document.querySelectorAll('input[name="edit_spec_names[]"]')).map(input => input.value);
        const editSpecValues = Array.from(document.querySelectorAll('input[name="edit_spec_values[]"]')).map(input => input.value);

        editSpecNames.forEach((name, index) => {
            formData.append('spec_names[]', name);
            formData.append('spec_values[]', editSpecValues[index] || '');
        });

        // Getting edited image if one was chosen
        const editImageInput = document.getElementById('edit-product-image');
        if (editImageInput.files.length > 0) {
            formData.append('image', editImageInput.files[0]);
        }

        // Laravel PUT support through POST + _method
        formData.append('_method', 'PUT');

        try {
            // Sending updated data to Laravel backend
            const response = await fetch(`/admin-inventory/products/${productId}`, {
                method: 'POST',
                headers: {
                    // CSRF token for Laravel security
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.ok) {
                closeEditModal();
                location.reload(); // Refresh page to show updated product
            } else {
                const errorText = await response.text();
                console.error(errorText);
                alert("Failed to update product.");
            }

        } catch (error) {
            console.error(error);
            alert("Error updating product.");
        }
    });

    renderAllProducts(allProducts);
</script>
</body>
</html>