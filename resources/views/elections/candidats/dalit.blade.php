<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ Route('elections.view',$e->id) }}" class="text-2xs text-gray-500 hover:text-blue-500">
                Elections Regions
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Register Candidates
            </a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="relative mt-6 mb-12 bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-8 border border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">Ward</span> Candidates
                </h1>

                <p class="mt-3 text-gray-500 text-sm md:text-base max-w-xl">
                    Registered Mayor candidates of
                    <span class="font-medium text-gray-700">
                        {{ $ward->palika->district->name_nepali }}, {{ $ward->name }}
                    </span>
                </p>
                <!-- Search -->
                <form method="GET" action="{{ Route('candidateDalit_search', ['id' => $ward->palika->id, 'e_id' => $e->id]) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search mayor"
                            class="w-full pl-5 pr-10 py-3 rounded-xl border border-gray-300
                                shadow-sm focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500 outline-none transition"
                        />
                        <span class="absolute right-4 top-3 text-gray-400">🔍</span>
                    </div>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl
                            hover:bg-indigo-700 shadow-md transition">
                        Search
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-3 bg-gray-100 p-2 rounded-xl shadow-inner">
              <a href="{{ Route('mayor.view', ['id' => $ward->palika->id, 'e_id' => $e->id]) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                    Mayor
                </a>

                <a href="{{ Route('candidate.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                    Chairperson
                </a>

                <a href="{{ Route('candidateMember.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                    Ward Member
                </a>

                <a href="{{ Route('candidateWomen.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                    Women
                </a>

                <a href="{{ Route('candidateDalit.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        bg-indigo-600 text-white shadow hover:bg-indigo-700">
                    Dalit
                </a>
            </div>

        </div>
    </div>

    <!-- ================= show data ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach ($candidate as $c)
        <div class=" w-full max-w-md mx-auto bg-white border border-gray-200 rounded-2xl shadow-lg p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $c->post }} Candidate</h2>
                </div>
                <a href="{{ Route('edit_candidate',['id' => $c->id, 'e_id' => $e->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs transition">
                    Edit
                </a>
            </div>
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="p-1 rounded-xl bg-indigo-500">
                        <img
                            src="{{ $c->photo }}"
                            alt="Profile Photo"
                            class="w-28 h-36 rounded-lg object-cover bg-white"
                        >
                    </div>
                </div>

                <div class="flex-1 text-sm space-y-2">
                    <div>
                        <span class="text-gray-500 text-xs">Name:</span>
                        <span class="font-semibold text-gray-800">{{ $c->citizen->name_nepali }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Party:</span>
                        <span class="font-semibold text-gray-700">{{ $c->party }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Region:</span>
                        <span class="font-semibold text-gray-700">{{ $c->district->name_nepali }}, {{ $c->palika->name }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Candidate Type:</span>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                            {{ $c->post }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-xs">Vote:</span>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                            {{ $c->vote }}
                        </span>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-200 my-4"></div>

            <a href="{{ Route('candidateProfile',['id' => $c->id, 'e_id' => $e->id]) }}" class="block w-full text-center px-4 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    View Full Profile
            </a>
        </div>
    @endforeach

    </div>

</x-defult_layout>
