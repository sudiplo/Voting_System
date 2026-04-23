<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('districts.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ District Management</a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                District <span class="text-indigo-600">Management</span>
            </h1>
            <p class="mt-2 text-gray-500">
                Districts, Palikas and Wards and their official records
            </p>
           <!-- Search Bar -->
                <form method="GET" action="{{ route('districts.index') }}" class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-2 max-w-md">
                    <input type="text" name="search" list="districts" value="{{ $search }}" placeholder="Search district..."
                        class="flex-1 px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition w-full">

                    <datalist id="districts">
                        @foreach ($suggestions as $suggestion)
                            <option value="{{ $suggestion }}"></option>
                        @endforeach
                    </datalist>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition w-full sm:w-auto">
                        Search
                    </button>
                </form>
        </div>

            <!-- ADD DISTRICT BUTTON -->
            <button id="add" data-dropdown-toggle="dropdown"
                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500
                  text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
                ➕ Add District
            </button>
        </div>

        <!-- ADD DISTRICT DROPDOWN -->
        <div id="dropdown" class="hidden mt-6 w-full sm:w-[28rem] rounded-2xl border border-gray-200 bg-white shadow-lg" >
            <!-- Header -->
            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800"> Add New District</h3>
                <p class="text-sm text-gray-500"> Enter district details in both English and Nepali.</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('distric.add') }}" class="p-5 space-y-4" onsubmit="return confirm('Are you sure you want to add this district?')" >
                @csrf
                <!-- District Name (English) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        District Name (English)
                    </label>
                    <input type="text" name="name" placeholder="e.g. Kathmandu" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                         focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <!-- District Name (Nepali) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        District Name (Nepali)
                    </label>
                    <input type="text" name="name_nepali" placeholder="जिल्लाको नाम" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                            transition">
                </div>

                <!-- Actions -->
                <div class="pt-3 border-t">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2
                            rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                            hover:bg-blue-700 active:scale-95
                            focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        💾 Save District
                    </button>
                </div>
            </form>
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
            <div>
                <form action="{{ Route('districts.Delete',$district->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <a href="{{ Route('districts.editView',$district->id) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">Edit</a>
                    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs" onclick="return confirm('Delete this palika?')">
                        Delete
                    </button>
                </form>
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

                            <a href="{{ Route('districts.palikaEdit',$p->id) }}"
                                class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                Edit
                            </a>
                            <form action="{{ Route('districts.palikaDelete',$p->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs" onclick="return confirm('Delete this palika?')">
                                    Delete
                                </button>
                            </form>
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
                                            <th class="px-4 py-2 text-left">Number</th>
                                            <th class="px-4 py-2 text-left">Ward Name</th>
                                            <th class="px-4 py-2 text-left">Voting Center</th>
                                            <th class="px-4 py-2 text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($p->wards as $ward)
                                        <tr class="border-t hover:bg-blue-50">
                                            <td class="px-4 py-2">{{ $ward->number }}</td>
                                            <td class="px-4 py-2">{{ $ward->name }}</td>

                                            <!-- Voting Center -->
                                            <td class="px-4 py-2">
                                                <table>
                                                    <tbody>
                                                        @forelse ($ward->votingCenters as $center)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ Route('districts.centerEdit',$center->id) }}" class="text-blue-400 hover:text-blue-600"> - {{ $center->name }}</a>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr><td class="text-gray-500 italic">No voting centers</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>

                                            <td class="p-4 text-center space-x-2">
                                                <a href="{{ Route('districts.wardEdit',$ward->id) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                                    Edit
                                                </a>
                                                <form action="{{ Route('districts.wardDelete',$ward->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs" onclick="return confirm('Delete this ward?')">
                                                        Delete
                                                    </button>
                                                </form>
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
</x-defult_layout>
