# Basket Badge - Merge Instructions

## Overview
The basket badge (red circle with item count) displays the total quantity of items in the user's basket in the header navigation.

**Feature:** Real-time badge that updates when items are added/removed from basket
**Location:** Header cart icon on all pages
**Database:** Reads from `basket_items` table (not session)

---

## ✅ Already Implemented In

### Files with badge working correctly:
- `resources/views/layouts/app.blade.php` (lines 67-87)
- `resources/views/displayproduct.blade.php` (has CSS link + badge code)
- `resources/views/basket.blade.php` (extends app.blade.php)
- `resources/views/payment.blade.php` (has CSS link)

### Updated files in basket branch:
- `resources/views/home-page.blade.php`
- `resources/views/product.blade.php`
- `resources/views/about-us.blade.php`
- `resources/views/contact-us.blade.php`
- `resources/views/login.blade.php`

---

## 🔧 Technical Implementation

### Required Components

**1. PHP Code (in header nav-icons section):**
```php
{{-- Basket Icon with Badge --}}
<a href="basket" class="cart-icon-wrapper">
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
```

**2. CSS Stylesheet Link (in `<head>`):**
```html
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

This loads the badge styles from `public/css/style.css` (lines 120-143):
```css
.cart-icon-wrapper {
    position: relative;
    display: inline-block;
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -10px;
    background-color: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}
```

---

## 📋 Merge Checklist

When merging branches to main, ensure:

### Option A: Convert to Shared Layout (Recommended)
1. ✅ Update pages to extend `layouts.app` instead of hardcoded headers
2. ✅ Remove hardcoded header/footer from each page
3. ✅ Badge will work automatically across all pages

### Option B: Add Badge to Each Page (If layouts can't be unified)
For each page with a hardcoded header:
1. ✅ Add `<link rel="stylesheet" href="{{ asset('css/style.css') }}">` in `<head>`
2. ✅ Replace cart icon with badge code (see above)
3. ✅ Test on each page individually

---

## 🎥 Demo

**See screen recording:** [Link to recording showing badge working on all pages]

**Visual proof:**
- Badge shows red circle with count
- Updates in real-time when items added/removed
- Works for both guests (session) and logged-in users (database)
- Appears on all pages: Home, About, Contact, Products, Product Detail, Basket, Checkout

---

## 🚨 Important Notes

- **Database-backed:** Badge reads from `basket_items` table, NOT session
- **Multi-user support:** Guests use session_id, logged-in users use user_id
- **Real-time:** Updates via AJAX when items are added without page refresh
- **Cross-device sync:** Logged-in users see same count across devices

---

## 🐛 Troubleshooting

**Badge not showing:**
- Check if `css/style.css` is linked in page head
- Verify BasketItem model is imported with `use App\Models\BasketItem;`
- Confirm page has badge PHP code in nav-icons section

**Badge shows wrong count:**
- Clear browser cache and refresh
- Check database `basket_items` table has correct data
- Verify session ID matches for guests

---

## 📞 Questions?

Contact: KP - Basket Branch Owner

Last Updated: March 21, 2026
