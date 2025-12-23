<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Console | Digital Voting</title>

  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
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

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: '#1e40af',
            accent: '#0ea5e9',
            success: '#16a34a',
            danger: '#dc2626',
            surface: '#f8fafc'
          },
          boxShadow: {
            panel: '0 15px 50px rgba(0,0,0,0.08)',
            hover: '0 25px 70px rgba(30,64,175,0.18)'
          }
        }
      }
    }
  </script>

  <style>
    .glass {
      backdrop-filter: blur(14px);
      background: rgba(255,255,255,0.88);
    }
    .tool {
      transition: all .25s ease;
    }
    .tool:hover {
      transform: translateY(-3px);
      box-shadow: 0 25px 60px rgba(30,64,175,0.18);
    }
  </style>
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-slate-100 text-gray-800">

@include('sweetalert::alert')

<div class="flex min-h-screen">

  <!-- ================= SIDEBAR (CONTROL CENTER) ================= -->
  <aside class="w-80 bg-white shadow-panel flex flex-col">

    <!-- BRAND -->
    <div class="px-6 py-5 border-b flex items-center gap-3">
      <div class="w-12 h-12 bg-gradient-to-br from-brand to-accent rounded-xl
                  flex items-center justify-center text-white font-bold text-lg">
        V
      </div>
      <div>
        <p class="font-semibold text-lg">Digital Voting</p>
        <p class="text-xs text-gray-500">National Admin Console</p>
      </div>
    </div>

    <!-- NAV -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 text-sm space-y-1">

      <p class="px-3 text-xs font-semibold text-gray-400 uppercase">Operations</p>

      <a href="{{ Route('dashboard') }}"  class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        📊 System Dashboard
      </a>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        🗳️ Elections Management
      </a>

      <a href="{{ Route('citizen.view') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        👥 Citizen Registry
      </a>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        🧾 Vote Monitoring
      </a>

      <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase">Administration</p>

      <a href="{{ Route('districts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        🏛️ Districts & Regions
      </a>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        👮 Officials & Roles
      </a>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        📑 Reports & Exports
      </a>

      <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase">System</p>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        ⚙️ Configuration
      </a>

      <a href="{{ Route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        🔐 Security & Permissions
      </a>

      <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
        📜 Audit Logs
      </a>
    </nav>

    <!-- USER -->
    <div class="border-t p-4 flex items-center gap-3">
      <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->photo }}">
      <div class="flex-1">
        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-danger hover:text-red-700">⎋</button>
      </form>
    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <div class="flex-1 flex flex-col">

    <!-- COMMAND BAR -->
    <header class="glass px-6 py-4 flex justify-between items-center shadow-sm">
      <div class="flex items-center gap-4">
        <input
          class="w-96 px-4 py-2 rounded-xl border focus:ring-2 focus:ring-brand outline-none"
          placeholder="Search citizens, elections, districts, logs..."
        />
        <span class="text-xs text-gray-400">⌘ K</span>
      </div>

      <div class="flex items-center gap-4">
        <button class="px-4 py-2 rounded-xl bg-brand text-white shadow hover:shadow-hover">
          + Create Election
        </button>
        <button class="relative">
          🔔
          <span class="absolute -top-1 -right-1 w-2 h-2 bg-danger rounded-full"></span>
        </button>
      </div>
    </header>

    <!-- WORKSPACE -->
    <!-- Hero Section -->
    <section class="px-10 flex flex-col items-center text-center fade-in">
        <h1 class="text-5xl font-bold text-gray-800 leading-tight">
            Digital <span class="text-blue-600">Voting</span> System
        </h1>
    </section>
    <!-- Image & Stats Section -->
  <section class="flex justify-center mt-20 relative fade-in">
    <img src="https://t4.ftcdn.net/jpg/03/77/39/37/360_F_377393789_XvtfKRNmrGP5CQYF86hgLMjZySyUXezu.jpg" class="rounded-xl w-50" />



    <!-- Right Card -->
    <div class="absolute right-10 bottom-10 bg-white/80 backdrop-blur p-4 rounded-xl shadow w-60">
      <div class="content-center flex md:flex-row space-x-3">
        <img src="https://cdn-icons-png.flaticon.com/512/169/169773.png" class="mt-2 w-20 " />
      </div>
    </div>
  </section>
      <!-- TOOL WORKBENCH -->
      {{-- <div class="bg-white rounded-2xl shadow-panel p-6"> --}}
        {{-- {{ $slot }} --}}
      {{-- </div> --}}

    </main>
  </div>
</div>

</body>
</html>
