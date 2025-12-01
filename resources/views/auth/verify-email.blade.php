<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify your email | Tecci</title>
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body class="signup-page">

    <main class="signup-main">
        <div class="signup-card">
            <div class="signup-header">
                <h1>Verify your email</h1>
                <p>
                    We’ve sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
                    Please click the link in that email to activate your account.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-success">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="signup-form">
                @csrf
                <button type="submit" class="signup-submit-btn">
                    Resend verification email
                </button>
            </form>
        <p class="signup-footer-text">
    Logged in as {{ auth()->user()->name }} – 
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Log out
    </a>
</p>

<form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>
        </div>
    </main> 

            