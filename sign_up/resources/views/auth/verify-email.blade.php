<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify your email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
<div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md space-y-4">

    <h1 class="text-xl font-bold">Verify your email address</h1>

    @if (session('success'))
        <div class="p-3 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <p class="text-sm text-gray-700">
        We’ve sent a verification link to your email address.
        Please click the link in that email to complete your registration.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="space-y-2">
        @csrf
        <button
            type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-sm">
            Resend verification email
        </button>
    </form>

</div>
</body>
</html>
