@extends('layouts.app')

@section('title', 'Verify Your Email | Tecci')

@section('body-class', 'signup-page')

@section('content')
<main class="signup-main">
    <div class="signup-card">

        <div class="signup-header">
            <h1>Verify your email</h1>
            <p>
                We’ve sent a verification link to 
                <strong>{{ auth()->user()->email }}</strong>.
            </p>
        </div>

        {{-- Status message --}}
        @if (session('status') == 'verification-link-sent')
            <div class="alert-success">
                A new verification link has been sent.
            </div>
        @endif

        {{-- Resend form --}}
        <form method="POST" action="{{ route('verification.send') }}" class="signup-form">
            @csrf
            <button type="submit" class="signup-submit-btn">
                Resend verification email
            </button>
        </form>

        {{-- Logout --}}
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
<<footer class="main-footer">
    <div class="container footer-inner">

        {{-- Column 1 --}}
        <div class="footer-col">
            <h3>TECCI</h3>
            <p>
                Smart Tech at Smart Prices.<br>
                Tecci makes premium devices accessible to<br>
                students and customers across the UK.
            </p>
        </div>

        {{-- Column 2 --}}
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul class="footer-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="/basket">Basket</a></li>
                <li><a href="/account">My Account</a></li>
            </ul>
        </div>

        {{-- Column 3 --}}
        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="contact-list footer-links">
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <span>0121 555 0198</span>
                </li>

                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <span>Tecci_Queries@net.com</span>
                </li>

                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Birmingham, B4 7ET</span>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Tecci. All rights reserved.</p>
    </div>
</footer>
