<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECCI - Contact Us</title>
    <link rel="stylesheet" href="{{ asset('css/styles') }}"/>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
  </head>
  
  <body>
    <div class="contact-container">
     <!-- White Form  -->
     <div class="contact-form">
      <form id="contactForm">
        <div class="form-row">
          <div class="form-group">
          <label for="first-name" class="input-label">FIRST NAME</label>
          <input type="text" id="first-name" placeholder="Please Enter First Name..." />
        </div>
        <div class="form-group">
          <label for="surname" class="input-label">SURNAME</label>
          <input type="text" id="surname" placeholder="Please Enter Last Name..." />
        </div>
      </div>
      <div class="form-group">
        <label for="phone" class="input-label">PHONE NUMBER</label>
        <input type="tel" id="phone" placeholder="Please Enter Phone Number..." />
      </div>
 
      <div class="form-group">
        <label for="email" class="input-label">EMAIL ADDRESS</label>
        <input type="email" id="email" placeholder="Please Enter Email Address..." />
      </div>
 
      <div class="form-group">
        <label for="message" class="input-label">WHAT DO YOU HAVE IN MIND?</label>
        <textarea id="message" placeholder="Please Enter Query..."></textarea>
      </div>
        <button type="submit">Submit</button>
      </form>
    </div>
 
    <!-- Blue Box -->
     <div class="contact-info">
      <h2>Get In Touch</h2>
      <p>Our team is happy to answer any of your queries. 
        Fill out the form and we’ll be in touch as soon as possible.</p>
      <div class="info-item">
        <i>📞</i> +44 1234567890</div>
      <div class="info-item">
        <i>📧</i> Tecci_Queries@net.com</div>
      <div class="info-item">
        <i>📍</i> B4 7ET</div>
    </div>
  </div>
</body>
</html>
