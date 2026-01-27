<x-top-layout>
    <!-- PAGE HEADER -->
    <div class="relative mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">{{ $election->title }} </span>
                </h2>
                <p class="mt-2 text-gray-500">
                    तपाईं विभिन्न क्षेत्रका उम्मेदवारहरू हेर्न सक्नुहुन्छ।
                </p>
                <!-- Search -->
                <form method="GET" action="{{ Route('elections.userDistrict',$election->id) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="जिल्ला वा पालिका खोज्नुहोस्..."
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

    <!-- DISTRICT LIST -->
    @foreach ($districts as $district)
    <div class="mb-12 bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">

        <!-- DISTRICT HEADER -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-white">{{ $district->name_nepali }}</h3>
                <p class="text-sm text-white/90">{{ $district->name }}</p>
            </div>

        </div>

        <!-- PALIKA TABLE -->
        <div class="p-8 overflow-x-auto">
            <table class="w-full text-sm border-collapse mt-2">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-4 text-left">Palika Name</th>
                        <th class="p-4 text-right w-40">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($district->palika as $p)
                    <tr class="border-b hover:bg-blue-50 transition text-lg">
                        <td class="p-4 font-medium text-blue-700 cursor-pointer">
                            <label for="palika-{{ $p->id }}" class="cursor-pointer">
                                {{ $p->name }}
                            </label>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ Route('Usermayor.view', ['id' => $p->id, 'e_id' => $election->id]) }}"
                                class="px-3 py-1 bg-blue-400 hover:bg-blue-500 text-white rounded text-xs">
                                View
                            </a>
                        </td>
                    </tr>

                    <!-- WARD SECTION -->
                    <tr>
                        <td colspan="2" class="p-0">
                            <input type="checkbox" id="palika-{{ $p->id }}" class="peer hidden">
                            <div class="peer-checked:block hidden bg-blue-50 border-t border-blue-200 p-6 space-y-4">
                                <!-- WARD TABLE -->
                                <table class="w-full border border-blue-200 rounded-lg overflow-hidden">
                                    <thead>
                                        <tr class="bg-blue-100 text-blue-800">
                                            <th class="px-4 py-2 text-left">Ward Number</th>
                                            <th class="px-4 py-2 text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($p->wards as $ward)
                                        <tr class="border-t hover:bg-blue-50">
                                            <td class="px-4 py-2">{{ $ward->number }}. {{ $ward->name }}</td>
                                            <td class="p-4  space-x-2">
                                                <a href="{{ Route('UserChairperson.view', ['id' =>$ward->id, 'e_id' => $election->id]) }}" class="px-3 py-1 bg-blue-400 hover:bg-blue-500 text-white rounded text-xs">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-center text-gray-500 italic">No wards available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="p-6 text-center text-gray-500 italic">No Palikas Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</x-top-layout>
