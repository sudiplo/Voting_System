<x-guest>

    @if($election && $election->count())
        <div class="relative mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">
            <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight"> Election Result</h2>
            <p class="mt-2 text-gray-500">Select the election to see result</p>
                <!-- Search -->
                <form method="GET" action="{{ Route('guest.search.election') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search election..."
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

        <div class="mt-5 space-y-4">
            @foreach ($election as $e)
                <div class="flex items-center justify-between
                            bg-white shadow-md rounded-lg p-4 border border-gray-200
                            hover:bg-indigo-50 transition">

                    <!-- Name -->
                    <div class="text-blue-700 font-medium">
                        {{ $e->title }}
                    </div>

                    <!-- Date -->
                    <div class="text-blue-700 font-medium">
                        {{ $e->election_date }}
                    </div>

                    <!-- Action -->
                    <div>
                        <a href="{{ route('guest.election.result', $e->id) }}"
                        class="inline-flex mt-1 bg-yellow-400 text-white px-3 py-1 font-medium rounded-md hover:bg-yellow-500 transition whitespace-nowrap">
                            Winner
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="relative mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">
            <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight"> Election Result</h2>
            <p class="mt-2 text-gray-500">Select the election to see result</p>
                <!-- Search -->
                <form method="GET" action="{{ Route('guest.search.election') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search election..."
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
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center mt-10 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200 text-center">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                No election data found yet!
            </h2>
            <p class="mt-2 text-gray-500 text-sm md:text-base">
                Please check back later or create a new election to see results.
            </p>
        </div>
    @endif

</x-guest>
