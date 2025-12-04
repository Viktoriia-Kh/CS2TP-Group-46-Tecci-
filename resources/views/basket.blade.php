<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="UTF-8">
       <title>Basket</title>
       <link rel="stylesheet" href="{{asset('style.css') }}"> <!-- created a link to the stylesheet-->
       <!-- Google font -->
       <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
   </head>
   <body>
   <!-- adding simple nav bar to the login page-->
   <nav class="login-navbar">
       <div class="navbar-left">
           <!-- logo -->
           <a href="/" class="logo">
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span>
         </a>
       </div>


       <div class="navbar-right">
           <a href="/homepage" class="homepage-link">Return To Home</a>
       </div>
   </nav>
       
    <div class="basket-wrapper">
        
        <div class="basket-header-row">
            <h1 class="basket-title">Your basket</h1>
            <div class="header-actions">
                <span class="free-delivery-text">
                    <i class="fas fa-truck"></i> spend £60.00 or more for free delivery
                </span>
                <a href="/homepage" class="btn-continue-top">CONTINUE SHOPPING</a>
                <button class="btn-checkout-top">CHECKOUT NOW</button>
            </div>
        </div>

        @if(empty($basket) || count($basket) == 0)
            <div class="empty-basket-message">
                <h2>Your basket is currently empty</h2>
                <a href="/homepage" class="btn-continue-top">Start Shopping</a>
            </div>
        @else
            <div class="basket-table-headers">
                <span class="header-desc">item description</span>
                <span class="header-price">price</span>
            </div>

            <div class="basket-items-list">
                @php $total = 0; @endphp
                @foreach($basket as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    
                    <div class="basket-item-row">
                        <div class="item-col-image">
                            <img src="{{ $details['image'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $details['name'] }}">
                        </div>

                        <div class="item-col-desc">
                            <h3 class="item-name">{{ strtolower($details['name']) }}</h3>
                            
                            <div class="item-meta">
                                <p>Shoe size: <span>3</span></p>
                                <p>Colour: <span>cobalt blue</span></p>
                            </div>

                            <div class="item-controls">
                                <label>quantity:</label>
                                <div class="qty-box">
                                    <input type="text" value="{{ $details['quantity'] }}" readonly>
                                    <div class="qty-arrows">
                                        <a href="{{ route('basket.add', $id) }}">▲</a>
                                        <a href="{{ route('basket.remove', $id) }}">▼</a>
                                    </div>
                                </div>
                            </div>

                            <div class="item-links">
                                <a href="#" class="change-link">change size</a>
                            </div>
                            
                            <a href="{{ route('basket.remove', $id) }}" class="remove-x">×</a>
                        </div>

                        <div class="item-col-price">
                            £{{ number_format($details['price'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="basket-footer-grid">
                
                <div class="footer-col-delivery">
                    <h4>delivery options <span class="sub-text">- select later on at checkout</span></h4>
                    <div class="delivery-row">
                        <span>uk standard</span>
                        <span>£3.99</span>
                    </div>
                    <div class="delivery-row">
                        <span>uk next day (free over £60)</span>
                        <span>£4.99</span>
                    </div>
                    <div class="delivery-row">
                        <span>uk sunday (free over £60)</span>
                        <span>£5.99*</span>
                    </div>
                    <a href="#" class="delivery-link">delivery options explained</a>
                </div>

                <div class="footer-col-payments">
                    <h4>we accept</h4>
                    <div class="payment-icons-grid">
                        <div class="pay-icon">VISA</div>
                        <div class="pay-icon">MC</div>
                        <div class="pay-icon">PAYPAL</div>
                        <div class="pay-icon">Apple Pay</div>
                    </div>
                </div>

                <div class="footer-col-totals">
                    <div class="totals-row">
                        <span>subtotal</span>
                        <span class="price-text">£{{ number_format($total, 2) }}</span>
                    </div>
                    
                    <button class="btn-update">UPDATE BASKET</button>
                    
                    <div class="discount-section">
                        <span>discount codes</span>
                        <span class="arrow">></span>
                    </div>

                    <div class="totals-row grand-total">
                        <span>grand total</span>
                        <span class="price-text">£{{ number_format($total, 2) }}</span>
                    </div>

                    <div class="final-actions">
                        <a href="/homepage" class="btn-continue-bottom">CONTINUE SHOPPING</a>
                        <button class="btn-checkout-bottom">CHECKOUT NOW</button>
                    </div>
                </div>
            </div>
        @endif
    </div>


   </body>


   <!-- creating a simple footer -->
   <footer class="basic-footer">
       <p>&copy; 2025 Tecci. All rights reserved.</p>
   </footer>


</html>