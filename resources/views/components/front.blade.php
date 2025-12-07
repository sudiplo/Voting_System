
{{--  --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Digital VOting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/css/app.css','resources/js/app.js'])
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
    {{-- <nav class="flex justify-between items-center px-10 py-6">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
            <h1 class="text-2xl font-semibold text-gray-800">Voting</h1>
        </div>
    </nav> --}}

  <!-- Hero Section -->
    <div class="px-10 mt-20 flex flex-col items-center text-center fade-in">
        <a href="{{ route('welcome') }}">
            <h1 class="text-5xl font-bold text-gray-800 leading-tight">
        Digital <span class="text-blue-600">Voting</span> System
        </h1>
        </a>

        <!-- Floating Icons -->
        <div class="absolute left-20 top-60 w-14 h-14 bg-white rounded-full shadow flex items-center justify-center float">
            <img src="https://png.pngtree.com/png-clipart/20220404/original/pngtree-online-vote-illustration-with-transparent-background-png-image_7511225.png" class="rounded-xl w-40" />
        </div>
    </div>


  <!-- slor Section -->
  <section class="flex justify-center mt-20 relative fade-in ">
    {{ $slot }}
  </section>

</body>
</html>

