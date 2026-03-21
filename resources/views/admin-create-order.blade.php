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
        <a href="{{ route('admin.orders.index') }}" style="text-decoration: none; color: #666;"><i class="fa-solid fa-arrow-left"></i> Back to Orders</a>

        <div style="margin-top: 20px;">
            <h1>Initiate New Order</h1>
            <p>Manually create an order for a customer.</p>
        </div>

        @if($errors->any())
            <div style="background: #ffdddd; color: #d8000c; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.orders.store') }}" method="POST" style="background: white; padding: 30px; border-radius: 8px; border: 1px solid #eee; margin-top: 20px;">
            @csrf

            <div style="margin-bottom: 25px;">
                <label style="font-weight: bold; display: block; margin-bottom: 10px;">1. Select Customer</label>
                <select name="user_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Choose a Customer --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: bold; display: block; margin-bottom: 10px;">2. Add Products</label>
                
                <div id="product-rows-container">
                    <div class="product-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <select name="products[0][id]" style="flex: 3; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (£{{ number_format($product->price, 2) }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="products[0][quantity]" placeholder="Qty" min="1" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                
                <button type="button" id="add-row-btn" style="background: #e9ecef; color: #333; padding: 8px 15px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; cursor: pointer; margin-top: 5px;">
                    <i class="fa-solid fa-plus"></i> Add Another Product
                </button>
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

            <button type="submit" style="background: #28a745; color: white; padding: 12px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
                Initiate Order
            </button>
        </form>
    </div>
  </section>
</main>

<script>
    let productRowIndex = 1;

    document.getElementById('add-row-btn').addEventListener('click', function() {
        // 1. Find the container and the first row
        const container = document.getElementById('product-rows-container');
        const firstRow = container.querySelector('.product-row');
        
        // 2. Clone the entire row perfectly (including all dropdown options)
        const newRow = firstRow.cloneNode(true);

        // 3. Update the 'name' attributes so Laravel knows they are new array items
        const select = newRow.querySelector('select');
        select.name = `products[${productRowIndex}][id]`;
        select.value = ''; // Reset to blank

        const input = newRow.querySelector('input');
        input.name = `products[${productRowIndex}][quantity]`;
        input.value = ''; // Reset to blank

        // 4. Append it to the page and increase our counter
        container.appendChild(newRow);
        productRowIndex++;
    });
</script>

</body>
</html>