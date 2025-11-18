<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create your account</title>
  {{-- Tailwind CDN (no Node/Vite needed) --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
  {{-- Header with Tecci branding --}}
  <header class="p-6">
    <div class="flex items-center gap-2">
      <img src="{{ asset('images/tecci.png') }}" alt="TECCI Logo" class="h-12">
    </div>
  </header>

  <div class="flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow">
      <div class="p-6 space-y-1 border-b">
        <h1 class="text-xl font-semibold">Create your account</h1>
        <p class="text-sm text-gray-600">Sign up for your Tecci Shop account</p>
      </div>

      <div class="p-6">
        <div class="space-y-3">
          {{-- Social buttons (wire these to real routes later) --}}
          <a href="#" class="w-full inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-gray-50">
            <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
              <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
              <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
              <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Continue with Google
          </a>

          <a href="#" class="w-full inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-gray-50">
            <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="#f25022" d="M1 1h10v10H1z"/><path fill="#00a4ef" d="M13 1h10v10H13z"/>
              <path fill="#7fba00" d="M1 13h10v10H1z"/><path fill="#ffb900" d="M13 13h10v10H13z"/>
            </svg>
            Continue with Microsoft
          </a>
        </div>

        {{-- Divider --}}
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t"></div>
          </div>
          <div class="relative flex justify-center text-xs uppercase">
            <span class="bg-white px-2 text-gray-500">Or continue with</span>
          </div>
        </div>

        {{-- Flash + errors --}}
        @if(session('success'))
          <div class="mb-4 rounded-md bg-green-50 p-3 text-green-700 text-sm">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 rounded-md bg-red-50 p-3 text-red-700 text-sm">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Sign Up Form (POST to controller) --}}
        <form action="{{ route('signup.submit') }}" method="POST" class="space-y-4">

         @csrf
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                   class="mt-1 block w-full rounded-md border px-3 py-2 text-sm focus:ring focus:ring-indigo-200">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="mt-1 block w-full rounded-md border px-3 py-2 text-sm focus:ring focus:ring-indigo-200">
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 block w-full rounded-md border px-3 py-2 text-sm focus:ring focus:ring-indigo-200">
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="mt-1 block w-full rounded-md border px-3 py-2 text-sm focus:ring focus:ring-indigo-200">
          </div>

          <button type="submit" class="w-full rounded-md bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700">
            Create Account
          </button>
        </form>

        <div class="mt-4 text-center text-sm">
          <span class="text-gray-600">Already have an account? </span>
          <a href="/login" class="text-indigo-600 hover:underline">Sign in</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>