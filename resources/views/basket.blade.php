{{-- copies the Header, Footer, and CSS from the Master File --}}
@extends('layouts.app')

{{-- sets the page title in the browser tab --}}
@section('title', 'Your Basket - Tecci')

{{-- this section gets injected into the middle of the page --}}
@section('content')

    {{-- Load specific styles for Basket --}}
    <link rel="stylesheet" href="{{ asset('css/basket.css') }}">

    {{-- wrapper with margin-top to prevent the fixed header from covering basket content --}}
    <div style="margin-top: 120px; min-height: 80vh; padding-bottom: 50px;">

        <div class="basket-wrapper">
            
            <div class="basket-header-row">
                <h1 class="basket-title">Your basket</h1>
                <div class="header-actions">
                    <span class="free-delivery-text">
                        <i class="fas fa-truck"></i> Spend £60.00 or more for FREE delivery
                    </span>
                    <a href="{{ route('products.index') }}" class="btn-continue-top">CONTINUE SHOPPING</a>
                    <a href="/checkout" class="btn-checkout-top">CHECKOUT NOW</a>
                </div>
            </div>

            @if(empty($basket) || count($basket) == 0)
                <div class="empty-basket-message">
                    <h2>Your basket is currently empty</h2>
                    <a href="{{ route('products.index') }}" class="btn-continue-top">Start Shopping</a>
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
                                <img src="{{ filter_var($details['image'], FILTER_VALIDATE_URL) ? $details['image'] : asset($details['image']) }}" alt="{{ $details['name'] }}" class="basket-product-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
                            </div>

                            <div class="item-col-desc">
                                <h3 class="item-name">{{ strtolower($details['name']) }}</h3>

                                <div class="item-controls">
                                    <label>quantity:</label>
                                    <div class="qty-box">
                                        <input type="text" value="{{ $details['quantity'] }}" readonly>
                                        <div class="qty-arrows">
                                            <a href="{{ route('basket.add', $id) }}">▲</a>
                                            <a href="{{ route('basket.decrease', $id) }}">▼</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('basket.remove', $id) }}" class="remove-item-link">remove item <span class="x-icon">×</span></a>
                            </div>

                            <div class="item-col-price">
                                £{{ number_format($details['price'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="basket-footer-grid">

                    <div class="footer-col-delivery">
                        <div class="delivery-selection-wrapper">
                            
                            <h4 class="delivery-header">Delivery Options - select before check out</h4>

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

                    <div class="footer-col-payments">
                        <h4>We accept</h4>
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
                            <span class="price-text" id="subtotal-amount">£{{ number_format($total, 2) }}</span>
                        </div>

                        <div class="totals-row">
                            <span>delivery</span>
                            <span class="price-text" id="delivery-cost">--</span>
                        </div>
                        
                        <div class="discount-wrapper">
                            <div class="discount-container">
                                {{-- HIDDEN INPUTS: Pass Session Data to JavaScript --}}
                                <input type="hidden" id="session-discount-code" value="{{ $discountCode ?? '' }}">
                                <input type="hidden" id="session-discount-multiplier" value="{{ $discountMultiplier ?? 1 }}">
                                
                                <input type="text" id="discount-input" placeholder="Enter Discount Code (e.g. xmas10)">
                                <button type="button" id="apply-btn">Apply</button>
                            </div>
                            <p id="message-area"></p>
                        </div>

                        <div class="totals-row grand-total">
                            <span>grand total</span>
                            <span class="price-text" id="checkout-total">£{{ number_format($total, 2) }}</span>
                        </div>

                        <div class="final-actions">
                            <a href="{{ route('products.index') }}" class="btn-continue-bottom">CONTINUE SHOPPING</a>
                            <a href="/checkout" class="btn-checkout-top">CHECKOUT NOW</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <script src="{{ asset('js/basket.js') }}"></script>

    </div>

@endsection