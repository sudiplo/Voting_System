<x-top-layout>

    <!-- PAGE HEADER -->
    <div class="relative mt-6 mb-12 bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-8 border border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">महिला सदस्य</span> उम्मेदवारहरू
                </h1>

                <p class="mt-3 text-gray-500 text-sm md:text-base max-w-xl">
                    <span class="font-medium text-gray-700">
                        {{ $ward->palika->district->name_nepali }}, {{ $ward->palika->name}}, {{ $ward->name }}
                    </span>
                </p>
                <!-- Search -->
                <form method="GET" action="{{ Route('UserWomen_search', ['id' => $ward->palika->id, 'e_id' => $e->id]) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search Women Candidate"
                            class="w-full pl-5 pr-10 py-3 rounded-xl border border-gray-300
                                shadow-sm focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500 outline-none transition"
                        />
                        <span class="absolute right-4 top-3 text-gray-400">🔍</span>
                    </div>
                </form>
            </div>
        </div>
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
                <a href="{{ Route('Usermayor.view', ['id' => $ward->palika->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Mayor
                </a>
            </li>

            <li>
                <a href="{{ Route('UserChairperson.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Chairperson
                </a>
            </li>

            <li>
                <a href="{{ Route('UserMember.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Member
                </a>
            </li>

            <li>
                <a href="{{ Route('UserWomen.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Women
                </a>
            </li>

            {{-- <li>
                <a href="{{ Route('UserDalit.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Dalit
                </a>
            </li> --}}
        </ul>
    </div>

   <!-- ================= show data ================= -->
    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach ($candidate as $mayor)
        <div class="relative bg-black rounded-xl overflow-hidden shadow-lg aspect-[3/4]">

            <img src="{{ $mayor->photo }}" alt="Profile" class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

            <!-- Content -->
            <div class="absolute bottom-0 w-full p-3 text-white">

                <h3 class="text-sm font-semibold truncate">
                    {{ $mayor->citizen->name_nepali }}
                </h3>

                <p class="text-[11px] text-gray-300 truncate">
                    {{ $mayor->party }}
                </p>

                <!-- Footer -->
                <div class="mt-2 flex items-center justify-between text-[11px]">
                    <span class="flex items-center gap-1">
                        {{ $mayor->post }}
                    </span>

                    <a href="{{ Route('UsercandidateProfile',['id'=>$mayor->id,'e_id'=>$e->id]) }}"
                    class="px-2 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white text-[10px] font-semibold">
                        view
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</x-top-layout>
