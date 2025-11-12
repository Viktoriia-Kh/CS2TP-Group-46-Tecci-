<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Create your account</h1>

    @if (session('success'))
      <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('signup.submit') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" required class="mt-1 w-full border px-3 py-2 rounded-md">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium">Email</label>
        <input type="email" name="email" id="email" required class="mt-1 w-full border px-3 py-2 rounded-md">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" name="password" id="password" required class="mt-1 w-full border px-3 py-2 rounded-md">
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 w-full border px-3 py-2 rounded-md">
      </div>

      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
        Create Account
      </button>
    </form>
  </div>
</body>
</html>
