<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Tecci | Affordable Tech for Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Links to HTML/CSS Files-->
    <link rel="stylesheet" href="homestyle.css" />
    <link rel="stylesheet" href="contactstyle.css" />
    <link rel="stylesheet" href="Aboutstyle.css" />
    <!--Google Font-->
    <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
    <!--Font Awesome for Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>

<body>
    <header class="main-header">
        <div class="container nav-container">

            <!-- Logo -->
            <a href="home-page-2.blade.php" class="logo">
                <!--Using this will make the Logo clickable and takes the user to the Home Page-->
                <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
                <span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
            </a>

            <!--Navigation Menu-->
            <nav class="main-nav">
                <ul>
                    <li><a href="home-page-2.blade.php">Home</a></li> <!--class="active" marks the Current Page-->
                    <li><a href="About-Us-2.blade.php" class="active">About</a></li>
                    <li><a href="contact-us.blade.php">Contact</a></li>
                    <li><a href="products.html">Products</a></li>
                </ul>
            </nav>

            <!--Icons-->
            <div class="nav-icons">
                <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a> <!--fa-heart is a Heart Icon linked from Font Awesome-->
                <a href="basket.html"><i class="fa-solid fa-cart-shopping"></i></a> <!--fa-cart-shopping is a Shopping Cart Icon linked from Font Awesome-->
                <a href="account.html"><i class="fa-regular fa-user"></i></a> <!--fa-user is a User Icon linked from Font Awesome-->
            </div>

        </div>
    </header>

    <main>
        <!--WHO ARE WE + STORY-->
        <!--Row 1: Who Are We? Image On The Right, Text On The Left-->
        <section class="about-row about-row-top">
            <div class="container about-row-grid">
                <div class="about-text-block">
                    <h1>Who Are We?</h1>
                    <p>
                        Tecci is an e-commerce platform created with one purpose in mind: To make quality
                        technology affordable, accessible, and stress-free for students and young professionals.
                    </p>
                    <p>
                        That’s why Tecci focuses on providing budget-friendly laptops, PCs, tablets, phones, and
                        accessories without compromising reliability or performance.
                    </p>
                </div>

                <div class="about-image-block">
                    <img src="Top-Right-Team-Image.png" alt="Students collaborating with laptops" />
                </div>
            </div>
        </section>

        <!--Row 2: Image On The Left, Story Behind Tecci Text On The Right-->
        <section class="about-row about-row-bottom">
            <div class="container about-row-grid about-row-reverse">
                <div class="about-image-block">
                    <img src="Bottom-Left-Black-And-White-Image.png" alt="Team working with laptops and notebooks" />
                </div>

                <div class="about-text-block">
                    <h2>The Story Behind Tecci</h2>
                    <p>
                        Tecci was created by a Team who understands the struggles of being a student. We’ve
                        experienced unreliable laptops, expensive repairs, and long hours searching for
                        affordable replacements. We understand that technology is essential for academic
                        success, creative projects, and everyday life — but it shouldn’t come with a heavy
                        price tag.
                    </p>
                    <p>
                        We wanted to build something better — a platform that students can trust, that balances
                        affordability with quality, and that makes online tech shopping straightforward and
                        reliable.
                    </p>
                </div>
            </div>
        </section>