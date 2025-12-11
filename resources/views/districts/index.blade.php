<x-top-layout>
    <div>
        {{-- <button id="add" data-dropdown-toggle="dropdown"
            class="inline-flex items-center  focus:ring-2 font-medium text-white text-sm px-2 py-2 focus:outline-none shadow-xl rounded bg-green-600" type="button">
            Add
        </button>
        <!-- Dropdown menu -->
        <div id="dropdown" class="z-10 hidden bg-[#F7F9FC] bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-72 p-2">
            <form method="POST" action="{{ route('distric') }}" class="max-w-sm mx-auto">
                @csrf
                <div class="mb-2">
                    <label for="name" :value="__('Name')" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                    <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
                </div>

                <div class="mb-2">
                    <label for="name" :value="__('Name')" class="block mb-2.5 text-sm font-medium text-heading">Name in nepali</label>
                    <input type="text" id="name_nepali" name="name_nepali" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <div class="p-4">
                        <button class="bg-blue-500 text-white text-sm px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Login</button>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>

    <div class="mb-10 bg-white/70 backdrop-blur-lg shadow-xl rounded-2xl border border-gray-200 overflow-hidden p-10">
        <div>
            {{-- Header --}}
            <h2 class="text-2xl font-bold text-gray-800">Districts
                {{-- add distric button --}}
                <button id="add" data-dropdown-toggle="dropdown"
                class="inline-flex items-center  focus:ring-2 font-medium text-white text-sm px-2 py-0.5 focus:outline-none shadow-xl rounded bg-green-600" type="button">
                    Add
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-[#e6ecf5] bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-72 p-2">
                    <form method="POST" action="{{ route('distric') }}" class="max-w-sm mx-auto">
                        @csrf
                        <div class="mb-2">
                            <label for="name" :value="__('Name')" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                            <input type="text" id="name" name="name"  class="w-full px-1 py-1 rounded-xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:outline-none transition" required />
                        </div>

                        <div class="mb-2">
                            <label for="name" :value="__('Name')" class="block mb-2.5 text-sm font-medium text-heading">Name in nepali</label>
                            <input type="text" id="name_nepali" name="name_nepali" class="w-full px-1 py-1 rounded-xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:outline-none transition" required />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <div class="p-1">
                                <button class="bg-blue-500 text-white text-sm px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </h2>

            <p class="text-gray-600 mb-8">Search and explore districts with their respective palikas.</p>


            {{-- Search Bar--}}
            <form method="GET" action="" class="max-w-md mb-10">
                <input
                    type="text"
                    name="search"
                    placeholder="Search district or palika..."
                    value="{{ request()->search }}"
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                >
                <button class="mt-3 bg-indigo-600 text-white px-5 py-2 rounded-xl shadow hover:bg-indigo-700 transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- DISTRICTS LIST -->
    @foreach ($districts as $district)
    <div class="mb-10 bg-white/70 backdrop-blur-lg shadow-xl rounded-2xl border border-gray-200 overflow-hidden p-10">

        <!-- District Header -->
        <div class="bg-green-600 px-6 py-4">
            <h3 class="text-xl font-semibold text-white">
                {{ $district->name_nepali ?? '—' }}
            </h3>
            <p class="text-white text-sm">
                {{ $district->name }}
            </p>
        </div>

        <!-- Palikas Table -->
        <div class="p-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="p-3 text-left font-semibold">Palika ID</th>
                        <th class="p-3 text-left font-semibold">Palika Name</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($district->palika as $p)
                        <tr class="border-b group hover:bg-indigo-50 transition cursor-pointer">
                            <td class="p-3 text-gray-700">{{ $p->id }}</td>
                            <td class="p-3 font-medium text-gray-800 group-hover:text-indigo-700">
                                {{ $p->name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-4 text-gray-500 italic text-center">
                                No Palikas Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</x-top-layout>
