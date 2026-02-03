<!DOCTYPE html>
<html lang="en">
  

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Link to CSS File for Contact Page-->
  <link rel="stylesheet" href="contactstyle.css" />
  <link rel="stylesheet" href="Dark-Mode.css" />
  <!--Google Font-->
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>
<body>
  <!--HEADER SECTION (SAME STRUCTURE AS HOME PAGE)-->
  <header class="main-header">
    <div class="container nav-container">

      <!--Logo-->
      <a href="/" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo" />
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="about-us">About</a></li>
          <li><a href="contact-us" class="active">Contact</a></li> <!--class="active" marks the Current Page-->
          <li><a href="displayproduct">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a>
        <a href="basket"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="login"><i class="fa-regular fa-user"></i></a>
      </div>

    </div>
  </header>

  <!--CONTACT SECTION-->
  <main>
    <section class="contact-section">
      <div class="container">
        <div class="contact-grid"> <!--This is where the two column layout begins-->

          <!--LEFT COLUMN: CONTACT FORM CARD-->
          <div class="contact-form-card">
            <form action="{{ route('contact.submit') }}" method="POST">
              @csrf
              <!--id gives the form a unique identifier used in JS-->
              <!--action tells the browser where to send the form data when it's submitted, this is part of backend-->
              <!--method="post" tells the browser how to send the form data, post sends the data in the HTTP body-->
              <!--novalidate allows you to handlevalidation yourself, so you can custom error messages-->

              <!--First Name-->
              <div class="form-row">
                <label for="firstName">First Name</label> <!--This is the description of the input-->
                <input type="text" id="firstName" name="first_name" placeholder="Please Enter First Name..." required />
                <!--type="text" is used for standard single-line text input-->
                <!--id in this case is used by the 'label for="firstName"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="firstNameError"></p>
                <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Last Name-->
              <div class="form-row">
                <label for="lastName">Last Name</label> <!--This is the description of the input-->
                <input type="text" id="lastName" name="last_name" placeholder="Please Enter Last Name..." required />
                <!--type="text" is used for standard single-line text input-->
                <!--id in this case is used by the 'label for="lastName"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="lastNameError"></p>
                <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Phone Number-->
              <div class="form-row">
                <label for="phone">Phone Number</label> <!--This is the description of the input-->
                <input type="text" id="phone" name="phone" inputmode="numeric" pattern="[0-9]*" placeholder="Please Enter Phone Number..." required />
                <!--type="tel" is used to indicate telephone input-->
                <!--id in this case is used by the 'label for="phone"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="phoneError"></p>
                <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Email Address-->
              <div class="form-row">
                <label for="email">Email Address</label> <!--This is the description of the input-->
                <input type="email" id="email" name="email" placeholder="Please Enter Email Address..." required />
                <!--type="email" is used as it is a basic email pattern check for the input-->
                <!--id in this case is used by the 'label for="phone"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="emailError"></p>
                <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Message-->
              <div class="form-row">
                <label for="message">What Do You Have In Mind?</label> <!--This is the description of the textarea-->
                <textarea id="message" name="issue" rows="5" placeholder="Please Enter Query..." required></textarea>
                <!--id in this case is used by the 'label for="message"' for accessibility-->
                <!--name is the key used in the data that is sent to the server/backend-->
                <!--rows is the initial suggested height-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="messageError"></p>
                <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Submit Button-->
              <div class="form-row">
                <button type="submit" class="btn btn-primary contact-submit-btn">Submit</button>
                <!--type="submit" makes the Button submit the form when clicked-->
              </div>

              <!--Success Message-->
              <p class="success-message" id="formSuccessMessage"></p>
              <!--This displays a message on successful form submission, which starts out empty/hiddent by default-->
            </form> <!--This closes the form element-->
          </div> <!--This closes the .contact-form-card-->

          <!--RIGHT COLUMN: BLUE CONTACT INFO PANEL-->
          <aside class="contact-info-panel"> <!-- This aside tag is used for 'complementary' content-->
            <div class="contact-info-inner">
              <h2>Get In Touch</h2>
              <p class="contact-info-text">
                Our team is happy to answer any of your queries. <br>
                Fill out the form and we'll be
                in touch <br> as soon as possible.
              </p>

              <div class="contact-info-items">
                <div class="contact-info-item">
                  <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
                  <span>0121 555 0198</span>
                </div>

                <div class="contact-info-item">
                  <i class="fa-regular fa-envelope"></i> <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
                  <span>Tecci_Queries@net.com</span>
                </div>

                <div class="contact-info-item">
                  <i class="fa-solid fa-location-dot"></i>
                  <!--fa-location-dot is a Location Icon linked from Font Awesome-->
                  <span>Birmingham, B4 7ET</span>
                </div>
              </div>
            </div>
          </aside>

        </div>
      </div>
    </section>
  </main>

  <!--FOOTER-->
  <footer class="site-footer">
    <div class="container footer-inner"> <!--footer-inner used to create multi-column layout-->
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
          <li><a href="displayproduct">Products</a></li>
          <li><a href="basket">Basket</a></li>
          <li><a href="login">My Account</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact Info</h4>
        <ul class="contact-list">
          <li>
            <i class="fa-solid fa-location-dot"></i> <!--fa-loocation-dot is a Location Icon linked from Font Awesome-->
            <span>0121 555 0198</span><br><br>
          </li>
          <li>
            <i class="fa-solid fa-phone"></i> <!--fa-phone is a Phone Icon linked from Font Awesome-->
            <span>Tecci_Queries@net.com</span><br><br>
          </li>
          <li>
            <i class="fa-regular fa-envelope"></i> <!--fa-envelope is an Envelope Icon linked from Font Awesome-->
            <span>Birmingham, B4 7ET</span><br><br>
          </li>
        </ul>
      </div>
    </div> <!--Closes <div class="container footer-inner"-->
    <div class="footer-bottom">
      <p>&copy; 2025 Tecci. All rights reserved.</p>
    </div>
  </footer>

  <!--Link to external JavaScript File-->
  <script src="contact-us.js"></script>
  <script src="Dark-Mode-Theme.js"></script>

</body>

</html>
