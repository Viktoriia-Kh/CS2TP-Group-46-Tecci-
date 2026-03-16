<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Tecci Account</title>
        <link rel="stylesheet" href="accountstyle.css"> <!-- created a link to the stylesheet-->
        <link rel="stylesheet" href="common-style.css">
        <!-- Google font-->
        <link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet'>
        <!-- Font awesome for icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    </head>

    <body>
        <header class="main-header">
            <div class="container nav-container">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('images/Logo.png') }}" alt="Tecci Logo">
                    <span class="logo-text">TECCI</span>
                </a>

                <!-- main nav bar-->
                <nav class="main-nav">
                    <ul>
                        <li><a href="{{ url('/')}}">Home</a></li>
                        <li><a href="about-us">About</a></li>
                        <li><a href="contact-us">Contact</a></li>
                        <li><a href="displayproduct">Products</a></li>
                    </ul>
                </nav>

                <!-- icons on the nav bar-->
                <div class="nav-icons">
                    <a href="#"><i class="fa-regular fa-heart"></i></a>
                    <a href="{{ url('basket')}}"><i class="fa-solid fa-cart-shopping"></i></a>
                    <a href="{{ url('account')}}"><i class="fa-regular fa-user"></i></a>
                </div>


            </div>
        </header>

        <main>
            <section>
                <h2>My Tecci Account</h2>
                <p>Manage your personal information.</p>
            </section>

            {{-- adding a success message for the user--}}
            @if (session('success'))
                <div class="success-messages">
                    {{session('success')}}
                </div>
            @endif

            {{-- adding error messages--}}
            @if ($errors->any())
                <ul class="error-messages">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif


            {{-- user can update and view their information here--}}
            <form method="POST" action="{{ route('account.update')}}">
                @csrf {{-- added this token for the security of the form--}}
                @method('PATCH') {{-- allows the user to make the partial changes--}}

                <div>
                    <!-- this is where the user will enter their full name-->
                    <label for="name">Full Name:</label>
                    <input type="text" name="name" id="name" value="{{ $user->name}}" required>
                </div>

                <div>
                    <!-- this is where the user will enter the email address-->
                    <label for="email">Email Address:</label>
                    <input type="email" name="email_address" id="email_address" value="{{ $user->email}}" required>
                </div>

                <button type="submit">Update Information</button>
            </form>

            {{-- logout button--}}
            <form action="{{ route('logout')}}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>

            {{--the user will be able to delete their account here--}}
            <form id="delete-form" action="{{ route('account.destroy')}}" method="POST">
                @csrf
                @method('DELETE') {{-- allows the user to delete their account--}}
                <button type="button" onclick="confirmAccountDeletion()">Delete Account</button>
            </form>

            {{-- javascript to handle the account deletion--}}
            <script>
                function confirmAccountDeletion() {
                    if(confirm('Are you sure you want to delete your Tecci account?')) {
                        document.getElementById('delete-form').submit();
                    }
                }
            </script>
        </main>


    </body>
</html>
