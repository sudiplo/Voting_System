<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Console | Digital Voting</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-slate-100 text-gray-800">
@include('sweetalert::alert')

<!-- MAIN LAYOUT -->
<div class="flex h-screen overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-70 bg-white shadow-panel flex flex-col overflow-y-auto">

        <!-- BRAND -->
        <div class="px-6 py-5 border-b flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-xl
                        flex items-center justify-center text-white font-bold text-lg">
                V
            </div>
            <div>
                <p class="font-semibold text-lg">Digital Voting</p>
                <p class="text-xs text-gray-500">National Admin Console</p>
            </div>
        </div>

        <!-- NAV -->
        <nav class="flex-1 px-4 py-6 text-sm space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase">Operations</p>

            <a href="{{ Route('Admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                📊 System Dashboard
            </a>

            <a href="{{ Route('elections.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                🗳️ Elections Management
            </a>

            <a href="{{ Route('citizen.view') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                👥 Citizen Registry
            </a>

            {{-- <a href="{{ Route('elections.vote') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                🧾 Vote Monitoring
            </a> --}}

            <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase">Administration</p>

            <a href="{{ Route('districts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                🏛️ Districts & Regions
            </a>

            {{-- <a href="" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                👮 Officials & Roles
            </a> --}}

            {{-- <a href="" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                📑 Reports & Exports
            </a> --}}

            <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase">System</p>

            {{-- <a href="" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                ⚙️ Configuration
            </a> --}}

            <a href="{{ Route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                🔐 Security & Permissions
            </a>

            <a href="{{ Route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                📜 About
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

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 overflow-y-auto">
        <div class="p-6">
            {{ $slot }}
                <!-- FOOTER NOTE -->
    <div class="mt-10 text-center text-xs text-gray-400">
        Digital Voting System • Sudip Lo
    </div>
        </div>
    </main>

</div>

</body>
</html>
