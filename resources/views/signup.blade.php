@extends('layouts.app')

@section('title', 'Sign Up | Tecci')

@section('body-class', 'signup-page')

@section('content')
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

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Error Messages --}}
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
                <input name="name" id="name" type="text" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input name="email" id="email" type="email" value="{{ old('email') }}" required>
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
            <a href="#">Login in</a>
        </p>

    </div>
</main>
@endsection
