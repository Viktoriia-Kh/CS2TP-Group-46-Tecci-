<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="{{asset('style.css') }}"> <!-- created a link to the stylesheet-->
    </head>
    <body>
        <img src="{{asset('images/Logo.png')}}" class="tecci-logo" alt="Tecci Logo"> <!-- linked the image file-->
        <section class="section-form">
            <h2>Welcome Back</h2>
            <p class="sub-message">Login to your Tecci account.</p>
            {{-- This will display error messages to the user--}}
            @if (!empty($error_messages))
                <ul class="error-messages">
                    @foreach ($error_messages as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <!-- adding the login form here for the user to fill in-->
            <form method="POST" action="{{route('login')}}"> <!-- once the form is submitted by the user it is sent to the login route-->
                @csrf {{-- this token is added for security of the form--}}

                <div>
                    <!-- this is where the user will enter the email address-->
                    <label for="email_address">Email address:</label>
                    <input type="email" name="email_address" id="email_address" required>
                </div>

                <div>
                    <!-- this is where the user will enter their password-->
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit">Login</button> <!-- allows the user to login-->

                <p class="signup-message">
                    Don't have an account? <a href="/signup">Sign up</a> <!-- redirects the user to signup to make an account-->
                </p>


            </form>

        </section>

    </body>

</html>
