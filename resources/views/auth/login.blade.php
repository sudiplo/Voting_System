{{-- <x-front>
    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full mx-auto space-y-6 transform transition-all duration-300 ease-in-out hover:scale-105">
        @csrf

        <h2 class="text-3xl font-semibold text-center text-gray-800">Welcome Back!</h2>
        <p class="text-center text-gray-600 text-sm">Please log in to your account</p>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="name@example.com" required autofocus />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="••••••••" required />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center">
            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-neutral-100 focus:ring-2 focus:ring-blue-300" required/>
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 transition" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
            <button type="submit" class="w-20 bg-blue-600 text-white py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none transition transform hover:scale-105">
                Login
            </button>
        </div>
    </form>

</x-front> --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Digital Voting System</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in {
      animation: fadeIn 1s ease-out forwards;
      opacity: 0;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.5);
    }
    .hover-lift {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
      transform: translateY(-3px);
      box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>
<body class="bg-gradient-to-br from-[#F7F9FC] to-blue-50 font-sans min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="flex justify-between items-center px-10 py-6 bg-white/70 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
      <h1 class="text-2xl font-semibold text-gray-800">Voting</h1>
    </div>
    <a href="/"><button class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition">Home</button></a>
  </nav>
  <!-- Main content: centered login form -->
  <div class="flex-grow flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md fade-in">
      <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10 transition-all duration-300 hover:shadow-3xl">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="mx-auto w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
          <p class="text-gray-500 mt-1">Sign in to your account</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
          @csrf

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                   placeholder="you@example.com">
            @error('email')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                   placeholder="••••••••">
            @error('password')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
              <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 transition">Forgot password?</a>
            @endif
          </div>

          <!-- Submit Button -->
          <button type="submit"
                  class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-[1.02] transition transform duration-200">
            Sign In
          </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center text-sm text-gray-600">
          Don't have an account?
          <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition">Create one now</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer (matches main page) -->
  <footer class="bg-gray-900 text-gray-400 py-6 mt-auto">
    <div class="text-center text-sm">
      Digital Voting System • Sudip Lo
    </div>
  </footer>
</body>
</html>
