<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Digital Voting System</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-[#F7F9FC] font-sans">

  <!-- Navbar -->
  <nav class="flex justify-between items-center px-10 py-6">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
      <h1 class="text-2xl font-semibold text-gray-800">Voting</h1>
    </div>
  </nav>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-cyan-50 px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 text-center">

        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-5 rounded-full bg-green-100 text-green-600 text-2xl">
            ✉️
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            Verify your email
        </h2>

        <p class="text-sm text-gray-600 leading-relaxed mb-6">
            Thanks for signing up! We’ve sent a verification link to your email address.
            Click the link to activate your account and start using the platform.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                ✅ A new verification link has been sent to your email.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:from-green-600 hover:to-emerald-700 hover:shadow-xl active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Resend verification email
            </button>
        </form>

        <p class="mt-6 text-xs text-gray-500">
            Didn’t receive the email?
            <br>
            Check your spam folder or try again in a few moments.
        </p>

        <p class="mt-8 text-xs text-gray-400">
            © {{ date('Y') }} Digital Voting System • Sudip Lo
        </p>

    </div>
</div>

</body>
</html>
