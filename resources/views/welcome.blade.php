<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Medicare Landing Page</title>
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
  </style>
</head>
<body class="bg-[#F7F9FC] font-sans">
  <!-- Navbar -->
  <nav class="flex justify-between items-center px-10 py-6">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
      <h1 class="text-2xl font-semibold text-gray-800">Voting</h1>
    </div>

    {{-- <ul class="flex space-x-10 text-gray-700 font-medium">
      <li class="cursor-pointer hover:text-blue-600">Home</li>
      <li class="cursor-pointer hover:text-blue-600">About</li>
      <li class="cursor-pointer hover:text-blue-600">Service</li>
      <li class="cursor-pointer hover:text-blue-600">Blog</li>
    </ul> --}}

    <!--login-->
    <a href="{{ route('login') }}"><button class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition">Log In</button></a>
  </nav>

  <!-- Hero Section -->
  <div class="px-10 mt-20 flex flex-col items-center text-center fade-in">
    <h1 class="text-5xl font-bold text-gray-800 leading-tight">
      Digital <span class="text-blue-600">Voting</span> System
    </h1>

    <p class="mt-4 text-gray-600 max-w-2xl">
      Register new voter.
    </p>

    <div class="flex space-x-6 mt-8">
      <a href="{{ route('register') }}" class="bg-blue-500 text-white px-8 py-3 rounded-full shadow hover:bg-blue-600 transition flex items-center space-x-2">
        <span>Voter Register</span>
      </a>

    </div>

    <!-- Floating Icons -->
    <div class="absolute left-20 top-64 w-14 h-14 bg-white rounded-full shadow flex items-center justify-center float"><img src="https://png.pngtree.com/png-clipart/20220404/original/pngtree-online-vote-illustration-with-transparent-background-png-image_7511225.png" class="rounded-xl w-40" />
</div>
  </div>

  <!-- Image & Stats Section -->
  <section class="flex justify-center mt-20 relative fade-in">
    <img src="https://t4.ftcdn.net/jpg/03/77/39/37/360_F_377393789_XvtfKRNmrGP5CQYF86hgLMjZySyUXezu.jpg" class="rounded-xl w-50" />



    <!-- Right Card -->
    <div class="absolute right-10 bottom-10 bg-white/80 backdrop-blur p-4 rounded-xl shadow w-60">
      <h3 class="text-gray-700 font-semibold">Avg. Adherence</h3>
      <p class="text-3xl font-bold text-gray-900">75%</p>
      <div class="content-center">
        <img src="https://cdn-icons-png.flaticon.com/512/169/169773.png" class="mt-2 w-20 " />
      </div>
    </div>
  </section>

  <div class="h-20"></div>
</body>
</html>
