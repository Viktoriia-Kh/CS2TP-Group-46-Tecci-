<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Secure Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Links to HTML/CSS Files-->
  <link rel="stylesheet" href="{{ asset('paymentstyle.css') }}" />
  <link rel="stylesheet" href="{{ asset('common-styles.css') }}" />
  <link rel="stylesheet" href="{{ asset('contactstyle.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/basket.css') }}" />
  <!--Google Font-->
  <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <style>
    .payment-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 30px;
      max-width: 1200px;
      margin: 50px auto;
      padding: 0 20px;
    }

    .form-section {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-section h3 {
      color: #03315b;
      margin-top: 0;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #eee;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #333;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .order-summary-box {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 20px;
      height: fit-content;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
      color: #666;
    }

    .summary-total {
      display: flex;
      justify-content: space-between;
      padding-top: 15px;
      margin-top: 15px;
      border-top: 2px solid #eee;
      font-size: 1.3rem;
      font-weight: bold;
    }

    .submit-btn {
      width: 100%;
      background: #005baf;
      color: white;
      padding: 15px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    .submit-btn:hover {
      background: #004a8f;
    }

    .error-box {
      background: #f8d7da;
      color: #721c24;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    @media (max-width: 900px) {
      .payment-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>

</head>

<body>
  <header class="main-header">
    <div class="container nav-container">

      <!-- Logo -->
      <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/" >Home</a></li>
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="{{ route('products.index') }}">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="/my-orders"><i class="fa fa-history" aria-hidden="true"></i></a>
        
        {{-- Basket Icon with Badge --}}
        <a href="{{ route('basket.index') }}" class="cart-icon-wrapper">
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
        
        <a href="/account"><i class="fa-regular fa-user"></i></a>
      </div>
    </div>
  </header>

  <section class="hero">

    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
      {{-- Progress Tracker --}}
      <div class="checkout-progress-container" style="margin-top: 60px; margin-bottom: 30px;">
          <div class="progress-step completed">
              <div class="step-icon">1</div>
              <div class="step-label">Basket</div>
          </div>
          <div class="progress-line completed"></div>
          <div class="progress-step active">
              <div class="step-icon">2</div>
              <div class="step-label">Checkout</div>
          </div>
      </div>
    </div>

    <div class="payment-grid">
      
      {{-- LEFT SIDE: Shipping + Payment Forms --}}
      <div>
        @if ($errors->any())
          <div class="error-box">
            <ul style="margin: 0; padding-left: 20px;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('payment.validate') }}" method="POST">
          @csrf
          
          {{-- Shipping Address Section --}}
          <div class="form-section" style="margin-bottom: 30px;">
            <h3><i class="fa-solid fa-truck"></i> Shipping Address</h3>
            
            <div class="form-row">
              <div class="form-group">
                <label>First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required>
              </div>
              <div class="form-group">
                <label>Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required>
              </div>
            </div>

            <div class="form-group">
              <label>Address Line 1 *</label>
              <input type="text" name="address_line1" value="{{ old('address_line1') }}" required>
            </div>

            <div class="form-group">
              <label>Address Line 2 (Optional)</label>
              <input type="text" name="address_line2" value="{{ old('address_line2') }}">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>City *</label>
                <input type="text" name="city" value="{{ old('city') }}" required>
              </div>
              <div class="form-group">
                <label>Postcode *</label>
                <input type="text" name="postcode" value="{{ old('postcode') }}" required>
              </div>
            </div>

            <div class="form-group">
              <label>Country *</label>
              <select name="country" required>
                <option value="United Kingdom" selected>United Kingdom</option>
                <option value="Ireland">Ireland</option>
              </select>
            </div>

            <div class="form-group">
              <label>Phone Number *</label>
              <input type="tel" name="phone" value="{{ old('phone') }}" required>
            </div>
          </div>

          {{-- Payment Details Section --}}
          <div class="form-section">
            <h3><i class="fa-solid fa-credit-card"></i> Payment Details</h3>
            
            <div class="form-group">
              <label>Name on Card *</label>
              <input type="text" name="card_name" value="{{ old('card_name') }}" required>
            </div>

            <div class="form-group">
              <label>Card Number *</label>
              <input type="text" name="card_number" maxlength="16" placeholder="1234567812345678" inputmode="numeric" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Expiry (MM/YY) *</label>
                <input type="text" name="expiry_date" maxlength="5" placeholder="MM/YY" required>
              </div>
              <div class="form-group">
                <label>CVV *</label>
                <input type="text" name="cvv" maxlength="3" placeholder="123" inputmode="numeric" required>
              </div>
            </div>

            <button type="submit" class="submit-btn">
              <i class="fa-solid fa-lock"></i> Confirm & Pay £{{ number_format($total, 2) }}
            </button>

            <p style="text-align: center; font-size: 0.8rem; color: #999; margin-top: 15px;">
              <i class="fa-solid fa-shield-halved"></i> Your payment information is secure
            </p>
          </div>
        </form>
      </div>

      {{-- RIGHT SIDE: Order Summary --}}
      <div>
        <div class="order-summary-box">
          <h3 style="margin-top: 0; color: #03315b;">Order Summary</h3>
          
          {{-- Cart Items --}}
          @foreach($cart as $item)
            <div style="display: flex; gap: 10px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
              <img src="{{ filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : asset($item['image']) }}" 
                   alt="{{ $item['name'] }}" 
                   style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
              <div style="flex: 1;">
                <p style="margin: 0 0 5px 0; font-weight: 600; color: #333;">{{ $item['name'] }}</p>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">Qty: {{ $item['quantity'] }}</p>
              </div>
              <p style="font-weight: 600; color: #333;">£{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
            </div>
          @endforeach

          {{-- Totals --}}
          <div class="summary-item">
            <span>Subtotal</span>
            <span>£{{ number_format($subtotal, 2) }}</span>
          </div>

          <div class="summary-item">
            <span>Delivery</span>
            <span>£{{ number_format($delivery, 2) }}</span>
          </div>

          @if($discount > 0)
            <div class="summary-item" style="color: #28a745;">
              <span>Discount</span>
              <span>-£{{ number_format($discount, 2) }}</span>
            </div>
          @endif

          <div class="summary-total">
            <span>Total</span>
            <span style="color: #005baf;">£{{ number_format($total, 2) }}</span>
          </div>

          <a href="{{ route('basket.index') }}" style="display: block; text-align: center; color: #666; margin-top: 20px; text-decoration: none; font-size: 0.9rem;">
            <i class="fa-solid fa-arrow-left"></i> Back to Basket
          </a>
        </div>
      </div>

    </div>
  </section>

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
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us">Contact</a></li>
          <li><a href="{{ route('products.index') }}">Products</a></li>
          <li><a href="{{ route('basket.index') }}">Basket</a></li>
          <li><a href="login">My Account</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact Info</h4>
        <ul class="contact-list">
          <li>
            <i class="fa-solid fa-location-dot"></i> 
            <span>0121 555 0198</span><br><br>
          </li>
          <li>
            <i class="fa-solid fa-phone"></i>
            <span>Tecci_Queries@net.com</span><br><br>
          </li>
          <li>
            <i class="fa-regular fa-envelope"></i>
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
