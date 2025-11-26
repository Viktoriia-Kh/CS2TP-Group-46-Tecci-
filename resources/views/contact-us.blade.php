<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Link to CSS File for Contact Page-->
  <link rel="stylesheet" href="contactstyle.css" />
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
      <a href="NewHome.html" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo" />
        <span class="logo-text">TECCI</span>
      </a>

      <!--Navigation Menu-->
      <nav class="main-nav">
        <ul>
          <li><a href="NewHome.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="NewContact.html" class="active">Contact</a></li> <!--class="active" marks the Current Page-->
          <li><a href="products.html">Products</a></li>
        </ul>
      </nav>

      <!--Icons-->
      <div class="nav-icons">
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a>
        <a href="basket.html"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="account.html"><i class="fa-regular fa-user"></i></a>
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
            <form id="contactForm" class="contact-form" action="contact-handler.php" method="post" novalidate>
              <!--id gives the form a unique identifier used in JS-->
              <!--action tells the browser where to send the form data when it's submitted, this is part of backend-->
              <!--method="post" tells the browser how to send the form data, post sends the data in the HTTP body-->
              <!--novalidate allows you to handlevalidation yourself, so you can custom error messages-->

              <!--First Name-->
              <div class="form-row">
                <label for="firstName">First Name</label> <!--This is the description of the input-->
                <input type="text" id="firstName" name="firstName" placeholder="Please Enter First Name..." required />
                <!--type="text" is used for standard single-line text input-->
                <!--id in this case is used by the 'label for="firstName"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="firstNameError"></p> <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Last Name-->
              <div class="form-row">
                <label for="lastName">Last Name</label> <!--This is the description of the input-->
                <input type="text" id="lastName" name="lastName" placeholder="Please Enter Last Name..." required />
                <!--type="text" is used for standard single-line text input-->
                <!--id in this case is used by the 'label for="lastName"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="lastNameError"></p> <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Phone Number-->
              <div class="form-row">
                <label for="phone">Phone Number</label> <!--This is the description of the input-->
                <input type="tel" id="phone" name="phone" placeholder="Please Enter Phone Number..." required />
                <!--type="tel" is used to indicate telephone input-->
                <!--id in this case is used by the 'label for="phone"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="phoneError"></p> <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Email Address-->
              <div class="form-row">
                <label for="email">Email Address</label> <!--This is the description of the input-->
                <input type="email" id="email" name="email" placeholder="Please Enter Email Address..." required />
                <!--type="email" is used as it is a basic email pattern check for the input-->
                <!--id in this case is used by the 'label for="phone"' for accessibility-->
                <!--name is the key used in the data that is sent to the server-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="emailError"></p> <!--This is reserved for the error text message which is initially empty-->
              </div>

              <!--Message-->
              <div class="form-row">
                <label for="message">What Do You Have In Mind?</label> <!--This is the description of the textarea-->
                <textarea id="message" name="message" rows="5" placeholder="Please Enter Query..." required></textarea>
                <!--id in this case is used by the 'label for="message"' for accessibility-->
                <!--name is the key used in the data that is sent to the server/backend-->
                <!--rows is the initial suggested height-->
                <!--required is a validation attribute which means the field cannot be left empty-->
                <p class="error-message" id="messageError"></p> <!--This is reserved for the error text message which is initially empty-->
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