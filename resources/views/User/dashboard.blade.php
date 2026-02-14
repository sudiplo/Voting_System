<x-top-layout>

    <!-- ================= Election Section ================= -->
    @if ($election)
    <section >

        <!-- Election Info -->
        {{-- <div class="mt-4 mb-8 border rounded-lg p-4 sm:p-6 bg-white">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                {{ $election->title }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ Auth::user()->citizen->ward->palika->district->name_nepali }}, {{ Auth::user()->citizen->ward->palika->name}}, {{ Auth::user()->citizen->ward->name }}
            </p>
            <a href="{{ Route('elections.vote') }}">VOte</a>
        </div> --}}
        <!-- Election Info -->
        <div class="mt-6 mb-8 bg-white border rounded-lg p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        {{ $election->title }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ Auth::user()->citizen->ward->palika->district->name_nepali }},
                        {{ Auth::user()->citizen->ward->palika->name }},
                        {{ Auth::user()->citizen->ward->name }}.
                        {{ \Carbon\Carbon::parse($election->election_date)->format('F j, Y') }}
                    </p>
                </div>

                <div>
                    <a href="{{ Route('elections.vote') }}" class="inline-block px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-200">
                        Vote Now
                    </a>
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
                    <a href="{{ Route('Usermayor.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Mayor
                    </a>
                </li>

                <li>
                    <a href="{{ Route('UserDeputymayor.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                         Deputy Mayor
                    </a>
                </li>

                <li>
                    <a href="{{ Route('UserChairperson.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Chairperson
                    </a>
                </li>

                <li>
                    <a href="{{ Route('UserMember.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Member
                    </a>
                </li>

                <li>
                    <a href="{{ Route('UserWomen.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                        Women
                    </a>
                </li>

                <li>
                    <a href="{{ Route('UserDalit.view', ['id' => Auth::user()->citizen->palika_id, 'e_id' => $election->id]) }}" class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
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
