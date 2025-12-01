<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecci | Sign Up</title>

    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
</head>

<body class="signup-page">

<header class="p-6">
    <div class="signup-logo-row">

        <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo" class="signup-logo" />
        <span class="brand-text">TECCI</span>
    </div>
</header>

<main class="signup-main">
    <div class="signup-card">

        <div class="signup-header">
            <h1>Create your account</h1>
            <p>Sign up for your Tecci Shop account</p>
        </div>

        {{-- Social Buttons --}}
        <div class="social-buttons">
            <a href="{{ route('auth.google') }}" class="social-btn">
                Continue with Google
            </a>

            <a href="{{ route('auth.microsoft') }}" class="social-btn">
                Continue with Microsoft
            </a>
        </div>

        <div class="signup-divider">Or continue with</div>

        {{-- Laravel Success Message --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Laravel Errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SIGNUP FORM --}}
        <form action="{{ route('signup.submit') }}" method="POST" class="signup-form">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input name="name" id="name" type="text" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input name="email" id="email" type="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" id="password" type="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input name="password_confirmation" id="password_confirmation" type="password" required>
            </div>

            <button type="submit" class="signup-submit-btn">
                Create Account
            </button>
        </form>

        <p class="signup-footer-text">
            Already have an account?
            <a href="#">Sign in</a>
        </p>

    </div>
</main>

</body>
</html>
