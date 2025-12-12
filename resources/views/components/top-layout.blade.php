<?php
    use App\Models\User;
?>
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

  <!-- Navbar -->
    <nav class="flex justify-between items-center px-10 py-6 bg-[#e9edf4] w-full">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white"><b>V</b></div>
        </div>

        <ul class="flex space-x-10 text-gray-700 font-medium fade-in p-5">
            <a href="{{ Route('dashboard') }}"><li class="cursor-pointer hover:text-blue-600 ">Home</li></a>
            <a href="{{ route('about') }}"><li class="cursor-pointer hover:text-blue-600">About</li></a>

            <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="cursor-pointer hover:text-blue-600"type="button">
            Register
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownDivider" class="z-10 hidden bg-[#F7F9FC] bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-50 rounded">
                <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownDividerButton">
                    <li class="hover:text-blue-600">
                        <a href="" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                        <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        Voter
                        </a>
                    </li>

                    <li class="hover:text-blue-600">
                        <a href="{{ Route('districts.index') }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                        <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M12 2C7.58 2 4 5.58 4 9c0 3.87 4 7.5 8 11 4-3.5 8-7.13 8-11 0-3.42-3.58-7-8-7zm0 10c-1.1 0-2-1.01-2-2s.9-2 2-2 2 1.01 2 2-.9 2-2 2z"/></svg>
                            Distric
                        </a>
                    </li>
                </ul>
            </div>

        </ul>

        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
            class="inline-flex items-center  focus:ring-2 font-medium text-white text-sm px-2 py-2 focus:outline-none shadow-xl rounded bg-green-600" type="button">
                {{ Auth::user()->name }}
        <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownInformation" class="z-10 hidden bg-[#F7F9FC] bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-72">
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

  <!-- Hero Section -->
  <section class="px-10 mt-10 flex flex-col items-center text-center fade-in">
    <h1 class="text-5xl font-bold text-gray-800 leading-tight">
      Digital <span class="text-blue-600">Voting</span> System
    </h1>


  </section>


<div class="px-10 mt-20  fade-in">
    {{ $slot }}
</div>

</body>
</html>
