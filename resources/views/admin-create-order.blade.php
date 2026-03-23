<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Tecci | Initiate Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('common-style.css') }}">
<link rel="stylesheet" href="{{ asset('admin-orders-styles.css') }}">
<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>

<header class="main-header">
  <div class="container nav-container">
    <div class="header-left-group">
      <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>
    </div>
    <div class="admin-header-spacer"></div>
  </div>
</header>

<main class="admin-shell">
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-profile">
      <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
      <div class="profile-meta">
        <p class="profile-name">Admin</p>
      </div>
    </div>
    <nav class="admin-nav">
      <a href="/admin-dashboard"><span class="nav-text">Dashboard</span><span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span></a>
      <a class="active" href="/admin-orders"><span class="nav-text">Orders</span><span class="nav-ico"><i class="fa-solid fa-receipt"></i></span></a>
      <a href="/admin-inventory"><span class="nav-text">Inventory</span><span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span></a>
    </nav>
  </aside>

  <section class="admin-content">
    <div class="admin-content-inner">
        
        <a href="{{ route('admin.orders.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>

        <div class="dash-title">
            <p class="dash-kicker">Manual Entry</p>
            <h1>Initiate New Order</h1>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; border-left: 4px solid #ef4444; margin-bottom: 24px; font-weight: 500;">
                <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="orders-panel">
            <form action="{{ route('admin.orders.store') }}" method="POST" class="create-order-form">
                @csrf

                <div class="form-section">
                    <h3><i class="fa-solid fa-user" style="margin-right: 8px; color: #26639f;"></i> 1. Select Customer</h3>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Choose a Customer --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-section">
                    <h3><i class="fa-solid fa-box-open" style="margin-right: 8px; color: #26639f;"></i> 2. Add Products</h3>
                    
                    <div id="product-rows-container">
                        <div class="product-row">
                            <select name="products[0][id]" class="form-control product-select">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (£{{ number_format($product->price, 2) }})</option>
                                @endforeach
                            </select>
                            
                            <input type="number" name="products[0][quantity]" class="form-control qty-input" placeholder="Qty" min="1">
                            
                            <button type="button" class="btn-danger-icon remove-row-btn" title="Remove Product">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" id="add-row-btn" class="btn-secondary-action">
                        <i class="fa-solid fa-plus"></i> Add Another Product
                    </button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit-order">
                        <i class="fa-solid fa-check"></i> Create Order
                    </button>
                </div>
            </form>
        </div>

    </div>
  </section>
</main>

<script>
    let productRowIndex = 1;

    // Logic for ADDING rows
    document.getElementById('add-row-btn').addEventListener('click', function() {
        const container = document.getElementById('product-rows-container');
        const firstRow = container.querySelector('.product-row');
        
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('select');
        select.name = `products[${productRowIndex}][id]`;
        select.value = ''; 

        const input = newRow.querySelector('input');
        input.name = `products[${productRowIndex}][quantity]`;
        input.value = ''; 

        container.appendChild(newRow);
        productRowIndex++;
    });

    // Logic for REMOVING rows
    document.getElementById('product-rows-container').addEventListener('click', function(e) {
        // Use .closest() just in case click FontAwesome icon inside the button
        const removeBtn = e.target.closest('.remove-row-btn');
        
        if (removeBtn) {
            const row = removeBtn.closest('.product-row');
            
            // If there is more than 1 row, delete the whole HTML row
            if (document.querySelectorAll('.product-row').length > 1) {
                row.remove();
            } else {
                // If it is the last row left, just clear the inputs instead of deleting it entirely
                row.querySelector('select').value = '';
                row.querySelector('input').value = '';
            }
        }
    });
</script>

</body>
</html>