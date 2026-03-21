@extends('layouts.app')

@section('title', 'Your Basket - Tecci')

@section('content')

    {{-- Load specific styles for Basket --}}
    <link rel="stylesheet" href="{{ asset('css/basket.css') }}">

    <div style="margin-top: 120px; min-height: 80vh; padding-bottom: 50px;">

        {{-- Progress Tracker --}}
        <div class="checkout-progress-container">
            <div class="progress-step active">
                <div class="step-icon">1</div>
                <div class="step-label">Basket</div>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="step-icon">2</div>
                <div class="step-label">Checkout</div>
                           
            </div>
        </div>

        <div class="basket-wrapper">
            
            {{-- Main Page Header --}}
            <div class="basket-header-row">
                <h1 class="basket-title">Your basket</h1>
                <div class="header-actions">
                    <span class="free-delivery-text">
                        <i class="fas fa-truck"></i> Spend £60.00 or more for FREE delivery
                    </span>
                </div>
            </div>

            @if(empty($basket) || count($basket) == 0)
                <div class="empty-basket-message">
                    <div class="empty-basket-icon">
                        <i class="fa-solid fa-cart-plus"></i>
                    </div>
                    <h2>Your basket is empty</h2>
                    <p>Looks like you haven't made your choice yet.</p>
                    <a href="{{ route('products.index') }}" class="btn-continue-top">Start Shopping</a>
                </div>
            @else
                
                {{-- 2-Column Grid --}}
                <div class="basket-layout-grid">
                    
                    {{-- LEFT COLUMN - Products & Delivery --}}
                    <div class="basket-main-content">
                        
                        {{-- Product Headers --}}
                        <div class="basket-table-headers">
                            <span class="header-desc">Product</span>
                            <span class="header-price">Price</span>
                        </div>

                        {{-- Product List --}}
                        <div class="basket-items-list">
                            @php $total = 0; @endphp
                            @foreach($basket as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                
                                <div class="basket-item-row">
                                    <div class="item-col-image">
                                        <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset($details['image']) }}" alt="{{ $details['name'] }}" class="basket-product-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
                                    </div>

                                    <div class="item-col-desc">
                                        <h3 class="item-name">{{ strtolower($details['name']) }}</h3>
                                        <div class="item-controls">
                                            <label>quantity:</label>

                                            <div class="qty-box">
                                                {{-- Added ID for JS targeting --}}
                                                <input type="text" id="qty-input-{{ $id }}" value="{{ $details['quantity'] }}" readonly>
                                                <div class="qty-arrows">

                                                    {{-- Buttons with Data Attributes --}}
                                                    <button type="button" class="ajax-qty-btn"
                                                     data-id="{{ $id }}"
                                                     data-name="{{ $details['name'] }}"
                                                     data-image="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset($details['image']) }}"
                                                     data-action="increase">▲</button>

                                                    <button type="button" class="ajax-qty-btn"
                                                     data-id="{{ $id }}"
                                                     data-name="{{ $details['name'] }}"
                                                     data-image="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset($details['image']) }}"
                                                     data-action="decrease">▼</button>
                                            </div>
                                        </div>
                                    </div>

                                        {{-- Remove Button --}}
                                        <button type="button" class="remove-item-link ajax-remove-btn"
                                         data-id="{{ $id }}"
                                         data-name="{{ $details['name'] }}"
                                         data-image="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset($details['image']) }}">
                                         remove item <span class="x-icon">×</span>
                                        </button>
                                        </div>

                                    <div class="item-col-price">
                                        £{{ number_format($details['price'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Delivery Options (left column) --}}
                        <div class="delivery-section">
                            <h4 class="delivery-header">Delivery Options</h4>
                            <div class="delivery-selection-wrapper">
                                <div class="delivery-row">
                                    <input type="checkbox" id="delivery-standard" class="delivery-checkbox delivery-group-checkbox">
                                    <label for="delivery-standard" class="delivery-label">
                                        UK Standard 3-5 working days (FREE over £60) - £3.99
                                    </label>
                                </div>
                                <div class="delivery-row">
                                    <input type="checkbox" id="delivery-premium" class="delivery-checkbox delivery-group-checkbox">
                                    <label for="delivery-premium" class="delivery-label">
                                        UK Next Day - £4.99
                                    </label>
                                </div>
                                <div id="delivery-error-msg" class="delivery-error"></div>
                            </div>
                        </div>

                        {{-- Payment Icons (left column) --}}
                        <div class="payment-section">
                            <h4>We accept</h4>
                            <div class="payment-icons-grid">
                                <i class="fa-brands fa-cc-visa pay-icon" style="color: #1A1F71;"></i>
                                <i class="fa-brands fa-cc-mastercard pay-icon" style="color: #EB001B;"></i>
                                <i class="fa-brands fa-cc-paypal pay-icon" style="color: #003087;"></i>
                                <i class="fa-brands fa-cc-apple-pay pay-icon" style="color: #000000;"></i>
                                <img src="https://x.klarnacdn.net/payment-method/assets/badges/generic/klarna.svg" alt="Klarna" class="pay-icon klarna-svg">
                            </div>
                        </div>

                    </div> {{-- End Left Column --}}


                    {{-- RIGHT COLUMN - Sticky Order Summary --}}
                    <div class="basket-sidebar">
                        <div class="order-summary-box">
                            <h3 class="summary-title">Order Summary</h3>
                            
                            <div class="totals-row">
                                <span>subtotal</span>
                                <span class="price-text" id="subtotal-amount">£{{ number_format($total, 2) }}</span>
                            </div>

                            <div class="totals-row">
                                <span>delivery</span>
                                <span class="price-text" id="delivery-cost">--</span>
                            </div>
                            
                            <div class="discount-wrapper">
                                <div class="discount-container">
                                    <input type="hidden" id="session-discount-code" value="{{ $discountCode ?? '' }}">
                                    <input type="hidden" id="session-discount-multiplier" value="{{ $discountMultiplier ?? 1 }}">
                                    
                                    <input type="text" id="discount-input" placeholder="Promo Code">
                                    <button type="button" id="apply-btn">Apply</button>
                                </div>
                                <p id="message-area"></p>
                            </div>

                            <div class="totals-row grand-total">
                                <span>Total</span>
                                <span class="price-text" id="checkout-total">£{{ number_format($total, 2) }}</span>
                            </div>

                            {{-- LOGIN WARNING for GUESTS --}}
                            @guest
                                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px; margin-bottom: 16px; text-align: center;">
                                    <i class="fas fa-exclamation-triangle" style="color: #856404; margin-right: 8px;"></i>
                                    <span style="color: #856404; font-size: 13px; font-weight: 500;">
                                        Please <a href="{{ route('login') }}" style="color: #007bff; text-decoration: underline;">log in</a> or 
                                        <a href="{{ route('signup.form') }}" style="color: #007bff; text-decoration: underline;">sign up</a> to checkout
                                    </span>
                                </div>
                            @endguest

                            <div class="final-actions-stacked">
                                @auth
                                    {{-- Logged in users can checkout --}}
                                    <a href="/checkout" class="btn-checkout-bottom checkout-validate">CHECKOUT NOW</a>
                                @else
                                    {{-- Guest users see disabled button that redirects to login --}}
                                    <a href="{{ route('login') }}" class="btn-checkout-bottom" style="background: #95a5a6; cursor: not-allowed;">
                                        LOGIN TO CHECKOUT
                                    </a>
                                @endauth
                                <a href="{{ route('products.index') }}" class="btn-continue-bottom">CONTINUE SHOPPING</a>
                            </div>
                        </div>
                    </div> {{-- End Right Column --}}

                </div> {{-- End Layout Grid --}}
            @endif
        </div>
        
        <script src="{{ asset('js/basket.js') }}"></script>

    </div>

@endsection
