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
          {{-- Social buttons --}}
        
            </svg>
            <a href="{{ route('auth.google') }}" class="w-full inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-gray-50">
    <!-- svg -->
    Continue with Google
</a>
          </a>
            </svg>
            <a href="{{ route('auth.microsoft') }}" class="w-full inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-gray-50">
    <!-- svg -->
    Continue with Microsoft
</a>
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
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
           <label for ="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

          <div>
            <button type="submit" class="w-full rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
              Create Account
            </button>
          </div>  
           