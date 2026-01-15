<x-top-layout>
    <!-- PAGE HEADER -->
    <div class="relative mt-6 mb-12 bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-8 border border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">नगर प्रमुख</span> उम्मेदवारहरू
                </h1>

                <p class="mt-3 text-gray-500 text-sm md:text-base max-w-xl">
                    <span class="font-medium text-gray-700">
                        {{ $palika->district->name_nepali }}, {{ $palika->name }}
                    </span>
                </p>
                    <div class="mt-5 flex items-center gap-3 bg-gray-100 p-2 rounded-xl shadow-inner">
                        <a href="{{ Route('Usermayor.view', ['id' => $palika->id, 'e_id' => $e->id]) }}"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                                bg-indigo-600 text-white shadow
                                hover:bg-indigo-700">
                                Mayor
                        </a>

                        <a href="{{ Route('UserDeputymayor.view', ['id' => $palika->id, 'e_id' => $e->id]) }}"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                                text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                                Deputy Mayor
                        </a>
                    </div>
                <!-- Search -->
                <form method="GET" action="{{ Route('UserMayor_search', ['id' => $palika->id, 'e_id' => $e->id]) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
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
        </div>
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
                        🗳 {{ $mayor->vote }}
                    </span>

                    <a href="{{ Route('candidateProfile',['id'=>$mayor->id,'e_id'=>$e->id]) }}"
                    class="px-2 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white text-[10px] font-semibold">
                        More info
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</x-top-layout>
