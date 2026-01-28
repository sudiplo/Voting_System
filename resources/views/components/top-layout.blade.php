<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Digital Voting System</title>
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
    @include('sweetalert::alert')


{{--  --}}
<header class="w-full border-b">

    <div class="flex items-center gap-4 px-5 py-4 bg-[#e9edf4]">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
        </div>

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-bold text-blue-700">
                Digital Voting System
            </h1>
            <p class="text-sm text-gray-600">
                Secure Online Election Platform
            </p>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="flex justify-between items-center px-10 py-3 bg-blue-700 text-white">

        <!-- Left Nav -->
        <ul class="flex space-x-8 font-medium">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-300 transition">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('elections.userIndex') }}" class="hover:text-yellow-300 transition">
                    Candidate
                </a>
            </li>
        </ul>

        <!-- Right User Dropdown -->
        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
            class="inline-flex items-center  focus:ring-2 font-medium text-white text-sm px-2 py-2 focus:outline-none shadow-xl rounded bg-green-600" type="button">
                {{ Auth::user()->name }}
        <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownInformation" class="z-10 hidden bg-[#F7F9FC] text-black bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-72">
            <div class="p-2">
            <div class="flex items-center px-2.5 p-2 space-x-1.5 text-sm bg-neutral-secondary-strong rounded">
                <img class="h-8 r-5" src="{{ Auth::user()->photo }}" alt="Rounded avatar">
                <div class="text-sm">
                <div class="font-medium text-heading">{{ Auth::user()->name }}</div>
                <div class="truncate text-body">{{ Auth::user()->email }}</div>
                </div>
            </div>
            </div>
            <ul class="px-2 pb-2 text-sm text-body font-medium" aria-labelledby="dropdownInformationButton">
            <li class="hover:text-blue-600">
                <a href="" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                Account
                </a>
            </li>
            <li class="hover:text-blue-600">
                <a href="/profile" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/></svg>
                Modify
                </a>
            </li>
            <li class="hover:text-blue-600">
                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                Help center
                </a>
            </li>
            <li class="p-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition w-full">
                        Logout
                    </button>
                </form>
            </li>
            </ul>
        </div>

    </nav>
</header>

{{--  --}}

    <div class="px-10 mt-5  fade-in">
        {{ $slot }}
    </div>

    {{-- footer --}}
    <footer class="bg-[#e9edf4] px-10 mt-20 w-full">

        <div class="px-6 sm:px-10 py-10">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700">

                <!-- Logo / About -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                            V
                        </div>
                        <span class="text-lg font-semibold">Digital Voting</span>
                    </div>
                    <p class="text-sm text-gray-600 max-w-sm">
                        A secure and transparent digital voting system designed to ensure fair elections and easy participation.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-md font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Home</a></li>
                        <li><a href="{{ route('elections.userIndex') }}" class="hover:text-blue-600">Candidates</a></li>
                        <li><a href="/profile" class="hover:text-blue-600">Profile</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-md font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-600">Help Center</a></li>
                        <li><a href="#" class="hover:text-blue-600">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-blue-600">Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h3 class="text-md font-semibold mb-4">Account</h3>

                    <div class="flex items-center space-x-3 mb-4">
                        <img
                            src="{{ Auth::user()->photo }}"
                            class="w-10 h-10 rounded-full object-cover"
                        >
                        <div class="text-sm">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm w-full">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-gray-300 text-center text-sm text-gray-600 py-4">
            © {{ date('Y') }} Digital Voting System. All rights reserved.
        </div>
    </footer>

</body>
</html>
