<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Digital Voting System</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in {
      animation: fadeIn 1.3s ease-in-out forwards;
      opacity: 0;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .float {
      animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }
    .hover-scale {
      transition: transform 0.2s ease;
    }
    .hover-scale:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body class="bg-[#F7F9FC] font-sans">

  <!-- Navbar -->
  <nav class="flex justify-between items-center px-10 py-6 bg-white/70 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
      <h1 class="text-2xl font-semibold text-gray-800">Voting</h1>
    </div>
    <a href="{{ route('login') }}"><button class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition">Log In</button></a>
  </nav>

  <!-- Hero Section -->
  <div class="px-10 mt-20 flex flex-col items-center text-center fade-in">
    <h1 class="text-5xl font-bold text-gray-800 leading-tight">
      Digital <span class="text-blue-600">Voting</span> System
    </h1>
    <p class="mt-4 text-gray-600 max-w-2xl">
      Secure, transparent, and accessible digital elections for the modern era.
    </p>

  </div>

  <div class="mt-5 py-5 px-10">
    {{ $slot }}
  </div>
  <!-- ========== NEW CONTENT SECTIONS (making page full) ========== -->

  <!-- Features Section -->
  <section class="max-w-6xl mx-auto px-6 py-16 fade-in">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800">Why Choose Our Voting Platform</h2>
      <p class="text-gray-500 mt-2">Secure, transparent, and built for the future of democracy</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
        </div>
        <h3 class="text-xl font-semibold">Secure & Encrypted</h3>
        <p class="text-gray-500 mt-2">Blockchain-based voting with end-to-end encryption ensures your vote is safe and tamper-proof.</p>
      </div>
      <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
        </div>
        <h3 class="text-xl font-semibold">Transparent Results</h3>
        <p class="text-gray-500 mt-2">Real-time vote counting with publicly verifiable audits. No manipulation, no doubts.</p>
      </div>
      <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h3 class="text-xl font-semibold">Instant Access</h3>
        <p class="text-gray-500 mt-2">Vote from anywhere, anytime. Mobile-friendly interface with accessibility features.</p>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="bg-white py-16 fade-in">
    <div class="max-w-6xl mx-auto px-6">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800">How It Works</h2>
        <p class="text-gray-500 mt-2">Three simple steps to cast your vote</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
          <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">1</div>
          <h3 class="text-lg font-semibold">Register</h3>
          <p class="text-gray-500 text-sm mt-2">Create your voter account and verify your identity securely.</p>
        </div>
        <div class="text-center">
          <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">2</div>
          <h3 class="text-lg font-semibold">Explore Elections</h3>
          <p class="text-gray-500 text-sm mt-2">View active elections, candidate profiles, and their agendas.</p>
        </div>
        <div class="text-center">
          <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">3</div>
          <h3 class="text-lg font-semibold">Vote & Track</h3>
          <p class="text-gray-500 text-sm mt-2">Cast your vote with one click and track results in real time.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="bg-blue-600 py-16 fade-in">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
      <h2 class="text-3xl font-bold">Ready to Make Your Voice Heard?</h2>
      <p class="mt-3 text-blue-100">Join thousands of voters already using our digital voting platform.</p>
      <div class="mt-8 flex flex-wrap justify-center gap-4">
        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold shadow-lg hover:bg-gray-100 transition">Register Now</a>
        <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white/10 transition">Log In</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 py-10">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <div class="flex items-center space-x-2 mb-4">
          <div class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">V</div>
          <span class="text-white font-semibold">Voting System</span>
        </div>
        <p class="text-sm">Secure digital elections for a better democracy.</p>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3">Quick Links</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-white transition">About Us</a></li>
          <li><a href="#" class="hover:text-white transition">How It Works</a></li>
          <li><a href="#" class="hover:text-white transition">Security</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3">Support</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-white transition">FAQ</a></li>
          <li><a href="#" class="hover:text-white transition">Contact</a></li>
          <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3">Follow Us</h4>
        <div class="flex space-x-4">
          <a href="#" class="hover:text-white transition">Twitter</a>
          <a href="#" class="hover:text-white transition">Facebook</a>
          <a href="#" class="hover:text-white transition">LinkedIn</a>
        </div>
      </div>
    </div>
    <div class="text-center text-sm text-gray-500 mt-8 pt-6 border-t border-gray-800">
      © 2025 Digital Voting System. All rights reserved.
    </div>
  </footer>

</body>
</html>
