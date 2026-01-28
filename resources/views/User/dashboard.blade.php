<x-top-layout>

    {{-- <!-- Hero Section -->
    <section class="px-10 flex flex-col items-center text-center fade-in">
        <h1 class="text-3xl font-bold text-gray-800 leading-tight">
            Digital <span class="text-blue-600">Voting</span> System
        </h1>
    </section>
    <!-- Image & Stats Section -->
    <section class="flex justify-center mt-10 relative fade-in">
        <img src="https://t4.ftcdn.net/jpg/03/77/39/37/360_F_377393789_XvtfKRNmrGP5CQYF86hgLMjZySyUXezu.jpg" class="rounded-xl w-50" />
    </section> --}}


    <!-- Hero Section -->
    <section class="relative px-6 sm:px-5 py-10 sm:py-20 flex flex-col items-center text-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-blue-500 to-purple-600"></div>

        <h1 class="relative text-3xl sm:text-5xl md:text-6xl font-extrabold text-white leading-tight">
            Digital <span class="text-yellow-300">Voting</span> System
        </h1>

        <p class="relative mt-4 text-sm sm:text-base md:text-lg text-indigo-100 max-w-xl sm:max-w-2xl">
            Empowering Democracy Through Technology
        </p>
    </section>

    <!-- Image Section -->
    {{-- <section class="flex justify-center -mt-16 sm:-mt-20 px-6 relative z-10">
        <div class="rounded-2xl overflow-hidden shadow-2xl max-w-md w-full">
            <img src="https://t4.ftcdn.net/jpg/03/77/39/37/360_F_377393789_XvtfKRNmrGP5CQYF86hgLMjZySyUXezu.jpg"
                class="w-full object-cover hover:scale-105 transition duration-700">
        </div>
    </section> --}}
    <!-- ================= Election Section ================= -->
    @if ($election)
    <section >

        <!-- Election Info -->
        <div class="mt-4 mb-8 border rounded-lg p-4 sm:p-6 bg-white">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                {{ $election->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{-- {{ $ward->palika->district->name_nepali }}, {{ $ward->palika->name}}, {{ $ward->name }} --}}
                {{ Auth::user()->citizen->ward->palika->district->name_nepali }}, {{ Auth::user()->citizen->ward->palika->name}}, {{ Auth::user()->citizen->ward->name }}
            </p>
        </div>

        <!-- Dropdown Button -->
        <button id="candidateDropdownButton" data-dropdown-toggle="candidateDropdown" data-dropdown-trigger="hover" class="inline-flex items-center justify-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 shadow font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" type="button">
            Select Candidate
            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 9-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="candidateDropdown" class="z-10 hidden bg-white border border-gray-200 rounded-lg shadow-lg w-44">
            <ul class="p-2 text-sm font-medium text-gray-600"
                aria-labelledby="candidateDropdownButton">

                <li>
                    <a href=""
                    class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Mayor
                    </a>
                </li>

                <li>
                    <a href=""
                    class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Chairperson
                    </a>
                </li>

                <li>
                    <a href=""
                    class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Member
                    </a>
                </li>

                <li>
                    <a href=""
                    class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Women
                    </a>
                </li>

                <li>
                    <a href=""
                    class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Dalit
                    </a>
                </li>
            </ul>
        </div>
        <!-- ================= show data ================= -->

        <!-- Candidate List -->
        @if ($candidates->isNotEmpty())
            <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($candidates as $candidate)
                <div class="relative bg-black rounded-xl overflow-hidden shadow-lg aspect-[3/4]">

                    <img src="{{ $candidate->photo }}" alt="Profile" class="absolute inset-0 w-full h-full object-cover">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                    <!-- Content -->
                    <div class="absolute bottom-0 w-full p-3 text-white">

                        <h3 class="text-sm font-semibold truncate">
                            {{ $candidate->citizen->name_nepali }}
                        </h3>

                        <p class="text-[11px] text-gray-300 truncate">
                            {{ $candidate->party }}
                        </p>

                        <!-- Footer -->
                        <div class="mt-2 flex items-center justify-between text-[11px]">
                            <span class="flex items-center gap-1">
                                {{ $candidate->post }}
                            </span>

                            <a href="{{ Route('UsercandidateProfile',['id'=>$candidate->id,'e_id'=>$candidate->election]) }}"
                            class="px-2 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white text-[10px] font-semibold">
                                view
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-center mt-10 text-gray-500">No Candidate available.</p>
        @endif

    </section>
    @else
        <p class="text-center mt-10 text-gray-500">No Election available.</p>
    @endif
</x-top-layout>
