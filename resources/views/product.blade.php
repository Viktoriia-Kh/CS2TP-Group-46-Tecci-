<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecci</title>
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>
<body>
    <header>
    <div class="header-top">
        <a href="#"><img src="{{asset('images/logo.png')}}" alt="Tecci logo" class="logo"></a>
        <div class="header-icons">
            <a href="#"><img src="{{asset('images/user.png')}}" alt="User Link" class="img"></a>
            <a href="#"><img src="{{asset('images/trolley.png')}}" alt="Products Link" class="img"></a>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Sign Up</a></li>
        </ul>
    </nav>
</header>

    <main>
        <section class="product-detail">
            <h1 class="product-name">Lorem Ipsum Dolor Sit Amet</h1>
            
            <div class="product-container">
                <div class="product-image-box">
                    <img src="{{asset('images/laptop.jpg')}}" alt="Product Image" class="product-image">
                </div>
                
                <div class="product-info-box">
                    <div class="product-price-box">
                        <span class="price-label">Price:</span>
                        <span class="price-value">€999.99</span>
                    </div>
                    
                    <div class="product-description-box">
                        <h3>Description</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Tecci. All Rights Reserved.</p>
    </footer>
</body>
</html>