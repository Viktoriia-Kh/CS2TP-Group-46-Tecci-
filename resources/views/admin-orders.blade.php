<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<title>Tecci | Orders Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Updated CSS File -->
<link rel="stylesheet" href="{{ asset('admin-orders-styles.css') }}">
<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
<!--Font Awesome for Icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* BULK ACTIONS BAR STYLES */
.bulk-actions-bar {
  display: none; /* Hidden by default, shown by JavaScript when items selected */
  position: sticky;
  top: 105px; /* Below sticky header */
  z-index: 800;
  background: linear-gradient(135deg, #1a4977 0%, #26639f 100%);
  padding: 16px 24px;
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(38, 99, 159, 0.3);
  align-items: center;
  justify-content: space-between;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bulk-actions-left {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #ffffff;
  font-weight: 600;
  font-size: 15px;
}

.bulk-actions-left i {
  font-size: 18px;
  color: #7fc0ff;
}

.selected-count {
  background: rgba(255, 255, 255, 0.2);
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 700;
}

.bulk-actions-right {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.bulk-action-btn {
  background: rgba(255, 255, 255, 0.15);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 10px 18px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.bulk-action-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.bulk-action-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.bulk-action-btn i {
  font-size: 13px;
}

.bulk-action-btn.danger {
  background: rgba(220, 53, 69, 0.2);
  border-color: rgba(220, 53, 69, 0.4);
}

.bulk-action-btn.danger:hover {
  background: rgba(220, 53, 69, 0.3);
}

/* Toast Notifications */
.bulk-toast {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: #ffffff;
  padding: 16px 24px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 600;
  z-index: 9999;
  opacity: 0;
  transform: translateX(400px);
  transition: all 0.3s ease;
}

.bulk-toast.show {
  opacity: 1;
  transform: translateX(0);
}

.bulk-toast-success {
  border-left: 4px solid #28a745;
  color: #155724;
}

.bulk-toast-success i {
  color: #28a745;
  font-size: 20px;
}

.bulk-toast-error {
  border-left: 4px solid #dc3545;
  color: #721c24;
}

.bulk-toast-error i {
  color: #dc3545;
  font-size: 20px;
}

/* Responsive */
@media (max-width: 768px) {
  .bulk-actions-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 15px;
  }
  
  .bulk-actions-right {
    width: 100%;
  }
  
  .bulk-action-btn {
    flex: 1;
    justify-content: center;
  }
}
</style>
</head>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
  <div class="container nav-container">
    <div class="header-left-group">
      <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>

      <a href="/admin-dashboard" class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
        <i class="fa-solid fa-bars"></i>
      </a>
    </div>

    <div class="admin-header-spacer"></div>

    <div class="nav-icons admin-top-icons">
      <a href="/admin-dashboard" aria-label="Notifications"><i class="fa-regular fa-bell"></i></a>
      <a href="/admin/contacts" aria-label="Messages"><i class="fa-regular fa-envelope"></i></a>
      <a href="/" aria-label="Home"><i class="fa-solid fa-house"></i></a>
    </div>
  </div>
</header>

<!--MAIN ADMIN LAYOUT-->
<main class="admin-shell">
  <!--SIDEBAR-->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-profile">
      <div class="profile-avatar">
        <i class="fa-solid fa-user-tie"></i>
      </div>
      <div class="profile-meta">
        <p class="profile-name">{{ Auth::user()->name }}</p>
        <p class="profile-role">Admin</p>
      </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>

    <a class="sidebar-logout" href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       LOGOUT
    </a>

    <nav class="admin-nav">
      <a href="/admin-dashboard">
        <span class="nav-text">Dashboard</span>
        <span class="nav-ico"><i class="fa-solid fa-chart-line"></i></span>
      </a>

      <a class="active" href="/admin-orders">
        <span class="nav-text">Orders</span>
        <span class="nav-ico"><i class="fa-solid fa-receipt"></i></span>
      </a>

      <a href="/admin-inventory">
        <span class="nav-text">Inventory</span>
        <span class="nav-ico"><i class="fa-solid fa-warehouse"></i></span>
      </a>

      <a href="/admin/customers">
        <span class="nav-text">Customers</span>
        <span class="nav-ico"><i class="fa-solid fa-user-group"></i></span>
      </a>

      <a href="{{ route('admin.contacts') }}">
        <span class="nav-text">Contact Messages</span>
        <span class="nav-ico"><i class="fa-solid fa-envelope"></i></span>
      </a>

      <a href="/admin-settings">
        <span class="nav-text">Admin Settings</span>
        <span class="nav-ico"><i class="fa-solid fa-gear"></i></span>
      </a>
    </nav>
  </aside>

  <!--PAGE CONTENT-->
  <section class="admin-content">
    <div class="admin-content-inner">


      <!-- PAGE TITLE WITH ACTION BUTTONS -->
<div class="dash-title orders-title">
  <div>
    <p class="dash-kicker">Hello Admin</p>
    <h1>Orders</h1>
  </div>
  <div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <!-- Export Button -->
    <a href="{{ route('admin.orders.export', request()->query()) }}" 
       class="btn-export-orders"
       title="Export current filtered results to CSV">
      <i class="fa-solid fa-download"></i>
      Export to CSV
    </a>
    
    <!-- Initiate New Order Button -->
    <a href="{{ route('admin.orders.create') }}" class="btn-initiate-order">
      <i class="fa-solid fa-plus"></i>
      Initiate New Order
    </a>
  </div>
</div>

      <!-- SEARCH BAR -->
      <div class="orders-search-row">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="page-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" 
                 name="search" 
                 placeholder="Search by Order ID or Customer Name..." 
                 value="{{ request('search') }}"
                 aria-label="Search orders">
          <button type="submit" style="display:none;"></button>
        </form>
      </div>

      <!-- BULK ACTIONS BAR (Hidden by default, shown when items selected) -->
      <div id="bulk-actions-bar" class="bulk-actions-bar">
        <div class="bulk-actions-left">
          <i class="fa-solid fa-check-circle"></i>
          <span class="selected-count" id="selected-count">0</span>
          <span>order(s) selected</span>
        </div>
        <div class="bulk-actions-right">
          <button type="button" class="bulk-action-btn" id="bulk-mark-shipped">
            <i class="fa-solid fa-truck"></i>
            Mark as Shipped
          </button>
          <button type="button" class="bulk-action-btn" id="bulk-mark-completed">
            <i class="fa-solid fa-check"></i>
            Mark as Completed
          </button>
          <button type="button" class="bulk-action-btn" id="bulk-print">
            <i class="fa-solid fa-print"></i>
            Print Invoices
          </button>
          <button type="button" class="bulk-action-btn danger" id="bulk-cancel">
            <i class="fa-solid fa-ban"></i>
            Cancel Orders
          </button>
        </div>
      </div>

      <!-- FILTERS BAR -->
      <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-filter-bar">
        <div class="orders-filter-left">
          <!-- Status Filter -->
          <div class="filter-select-wrap">
            <select name="status_filter" onchange="this.form.submit()" aria-label="Filter by order status">
              <option value="">Any Status</option>
              <option value="Pending" {{ request('status_filter') == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="Approved" {{ request('status_filter') == 'Approved' ? 'selected' : '' }}>Approved</option>
              <option value="Shipped" {{ request('status_filter') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
              <option value="Completed" {{ request('status_filter') == 'Completed' ? 'selected' : '' }}>Completed</option>
              <option value="Cancelled" {{ request('status_filter') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
          </div>

          <!-- Price Filter -->
          <div class="filter-select-wrap">
            <select name="price_filter" onchange="this.form.submit()" aria-label="Filter by price range">
              <option value="">All Prices</option>
              <option value="0-100" {{ request('price_filter') == '0-100' ? 'selected' : '' }}>£0 - £100</option>
              <option value="100-500" {{ request('price_filter') == '100-500' ? 'selected' : '' }}>£100 - £500</option>
              <option value="500-1000" {{ request('price_filter') == '500-1000' ? 'selected' : '' }}>£500 - £1000</option>
              <option value="1000+" {{ request('price_filter') == '1000+' ? 'selected' : '' }}>£1000+</option>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
          </div>
        </div>

        <!-- Sort Control -->
        <div class="orders-filter-right">
          <div class="filter-select-wrap sort-select">
            <select name="sort" onchange="this.form.submit()" aria-label="Sort orders">
              <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Sort by Date (Newest)</option>
              <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Sort by Date (Oldest)</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Sort by Price (Low-High)</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Sort by Price (High-Low)</option>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
          </div>
        </div>
      </form>

      <!-- ORDERS TABLE PANEL -->
      <section class="orders-panel">
        <div class="orders-table-wrap">
          <table class="orders-table">
            <thead>
              <tr>
                <th class="checkbox-col">
                  <input type="checkbox" id="select-all-orders" aria-label="Select all orders">
                </th>
                <th>Order</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Price</th>
                <th>Date</th>
              </tr>
            </thead>

            <tbody>
              @forelse($orders as $order)
                <tr>
                  <td class="checkbox-col">
                    <input type="checkbox" 
                           class="order-checkbox" 
                           value="{{ $order->id }}" 
                           aria-label="Select order {{ $order->id }}">
                  </td>
                  
                  <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="order-number-link">
                      #{{ $order->id }}
                    </a>
                  </td>
                  
                  <td>{{ $order->user->name ?? 'Guest' }}</td>
                  
                  <td>
                    <!-- Status Dropdown with Auto-submit -->
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" 
                          method="POST" 
                          style="display:inline-block;">
                      @csrf
                      @method('PUT')
                      <select name="status" 
                              onchange="this.form.submit()"
                              class="status-pill status-{{ strtolower($order->status) }}"
                              aria-label="Change order status">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $order->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                      </select>
                    </form>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="view-details-link">
                      View Details
                    </a>
                  </td>
                  
                  <td>£{{ number_format($order->total_price, 2) }}</td>
                  
                  <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="empty-state">
                      <i class="fa-solid fa-inbox"></i>
                      <p>No orders found matching those filters.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <!-- PAGINATION -->
          @if($orders->hasPages())
            <div class="pagination-wrap">
              {{ $orders->appends(request()->query())->links() }}
            </div>
          @endif
        </div>
      </section>

    </div>
  </section>
</main>

<!--FOOTER-->
<footer class="site-footer">
  <div class="container footer-inner">
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
          <span>Birmingham, B4 7ET</span>
        </li>
        <li>
          <i class="fa-solid fa-phone"></i>
          <span>0121 555 0198</span>
        </li>
        <li>
          <i class="fa-regular fa-envelope"></i>
          <span>Tecci_Queries@net.com</span>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="footer-bottom">
    <p>&copy; 2025 Tecci. All rights reserved.</p>
  </div>
</footer>

<!--JavaScript-->
<script src="{{ asset('TP2_Admin_Dashboard.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Grab all our elements
    const selectAllCheckbox = document.getElementById('select-all-orders');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    
    let selectedOrders = [];

    // 2. UI Updater Function
    function updateUI() {
        if (selectedOrders.length > 0) {
            if (bulkActionsBar) bulkActionsBar.style.display = 'flex';
            if (selectedCountSpan) selectedCountSpan.textContent = selectedOrders.length;
        } else {
            if (bulkActionsBar) bulkActionsBar.style.display = 'none';
        }

        // Sync the Select All checkbox visually
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (selectedOrders.length > 0 && selectedOrders.length === orderCheckboxes.length);
        }
    }

    // 3. Select All Logic
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function(e) {
            const isChecked = e.target.checked;
            selectedOrders = []; // Reset array
            
            orderCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked; // Visually check/uncheck
                if (isChecked) {
                    selectedOrders.push(checkbox.value); // Add to array
                }
            });
            updateUI();
        });
    }

    // 4. Individual Checkbox Logic
    orderCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function(e) {
            const orderId = e.target.value;
            if (e.target.checked) {
                if (!selectedOrders.includes(orderId)) selectedOrders.push(orderId);
            } else {
                selectedOrders = selectedOrders.filter(id => id !== orderId);
            }
            updateUI();
        });
    });

    // 5. Toast Notification Function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `bulk-toast bulk-toast-${type}`;
        toast.innerHTML = `
            <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // 6. Action Button Logic
    function setupBulkBtn(id, actionStr) {
        const btn = document.getElementById(id);
        if (!btn) return;
        
        btn.addEventListener('click', function(e) {
            if (selectedOrders.length === 0) return;
            
            // Confirm with user
            let actionName = actionStr.charAt(0).toUpperCase() + actionStr.slice(1);
            if (!confirm(`Are you sure you want to mark ${selectedOrders.length} order(s) as ${actionName}?`)) {
                return;
            }

            // Show loading state safely
            const currentBtn = e.currentTarget;
            const originalText = currentBtn.innerHTML;
            currentBtn.disabled = true;
            currentBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

            fetch('/admin-orders/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    action: actionStr,
                    order_ids: selectedOrders
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Success! ' + data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast('Error: ' + data.message, 'error');
                    currentBtn.disabled = false;
                    currentBtn.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                showToast('A network error occurred.', 'error');
                currentBtn.disabled = false;
                currentBtn.innerHTML = originalText;
            });
        });
    }

    // Hook up the buttons
    setupBulkBtn('bulk-mark-shipped', 'shipped');
    setupBulkBtn('bulk-mark-completed', 'completed');
    setupBulkBtn('bulk-cancel', 'cancelled');

    // Print Button logic
    const printBtn = document.getElementById('bulk-print');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            if (selectedOrders.length === 0) return;
            window.open('/admin-orders/print?ids=' + selectedOrders.join(','), '_blank', 'width=800,height=600');
        });
    }
});
</script>

</body>
</html>
