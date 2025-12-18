<x-top-layout>

<!-- ===================== PAGE HEADER ===================== -->
<div class="mb-10 bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">District Management</h2>
            <p class="text-gray-600 mt-1">Manage districts, palikas and wards</p>
            <!-- Search Bar -->
            <form method="GET" action="{{ route('districts.index') }}"class="max-w-md mb-10 p-2">
                <input type="text" name="search" list="districts" value="{{ $search }}" placeholder="Search district..."class="w-50 px-5 py-3 rounded-xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:outline-none transition" >

                <datalist id="districts">
                    @foreach ($suggestions as $suggestion)
                    <option value="{{ $suggestion }}">
                    @endforeach
                </datalist>

                <button type="submit" class="mt-3 w-50 px-2 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" > Search </button>
            </form>
        </div>



        <!-- ADD DISTRICT -->
        <button
            id="add"
            data-dropdown-toggle="dropdown"
            class="bg-green-600 hover:bg-green-700 text-white px-2 py-2 rounded-lg shadow transition"
        >
            + Add District
        </button>
    </div>

    <!-- ADD DISTRICT DROPDOWN -->
    <div id="dropdown" class="hidden mt-4 bg-gray-50 border rounded-xl p-4 w-96 shadow">
        <form method="POST" action="{{ route('distric.add') }}">
            @csrf
            <div class="space-y-3">
                <input type="text" name="name" placeholder="District name"
                    class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400" required>

                <input type="text" name="name_nepali" placeholder="District name (Nepali)"
                    class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400" required>

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg" onclick="return confirm('Add this district?')">
                    Save District
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================== DISTRICT LIST ===================== -->
@foreach ($districts as $district)
<div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden">

    <!-- DISTRICT HEADER -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-8 py-6 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-white">{{ $district->name_nepali }}</h3>
            <p class="text-sm text-white/90">{{ $district->name }}</p>
        </div>

        <!-- ADD PALIKA -->
        <form action="{{ route('palika.add') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="hidden" name="district_id" value="{{ $district->id }}">
            <input
                type="text"
                name="name"
                placeholder="Add Palika"
                class="px-3 py-2 rounded-lg text-sm border"
                required
            >
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg" onclick="return confirm('Add this palika?')">
                Add
            </button>
        </form>
    </div>

    <!-- ===================== PALIKA TABLE ===================== -->
    <div class="p-8">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-4 text-left">Palika Name</th>
                    <th class="p-4 text-right w-40">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($district->palika as $p)
                <!-- PALIKA ROW -->
                <tr class="border-b hover:bg-indigo-50 transition text-xl">
                    <td class="p-4 font-medium text-indigo-700 cursor-pointer">
                        <label for="palika-{{ $p->id }}" class="cursor-pointer">
                            {{ $p->name }}
                        </label>
                    </td>

                    <!-- ACTIONS -->
                    <td class="p-4 text-right space-x-2">
                        <a href=""
                            class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                            Edit
                        </a>

                        <form action="{{ Route('districts.palikaDelete',$p->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs"
                                onclick="return confirm('Delete this palika?')"
                            >
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- ===================== WARD SECTION ===================== -->
                <tr>
                    <td colspan="2" class="p-0">
                        <input type="checkbox" id="palika-{{ $p->id }}" class="peer hidden">

                        <div class="peer-checked:block hidden bg-indigo-50 border-t border-indigo-200 p-6 space-y-4">
                            <label for="palika-{{ $p->id }}" class="cursor-pointer">
                                {{ $p->name }}
                            </label>
                            <!-- ADD WARD -->
                            <form action="{{ route('ward.add') }}" method="POST" class="flex flex-wrap gap-2">
                                @csrf
                                <input type="hidden" name="palika_id" value="{{ $p->id }}">

                                <input type="number" name="number" placeholder="Ward No"
                                    class="w-24 px-3 py-2 rounded border" required min="1">

                                <input type="text" name="name" placeholder="Ward Name"
                                    class="px-3 py-2 rounded border" required>

                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 rounded" onclick="return confirm('Add this ward?')">
                                    + Add Ward
                                </button>
                            </form>

                            <!-- WARD TABLE -->
                            <table class="w-full border border-indigo-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-indigo-100 text-indigo-800">
                                        <th class="px-4 py-2 text-left">Number</th>
                                        <th class="px-4 py-2 text-left">Ward Name</th>
                                        <th class="px-4 py-2 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($p->wards as $ward)
                                    <tr class="border-t hover:bg-indigo-100">
                                        <td class="px-4 py-2">{{ $ward->number }}</td>
                                        <td class="px-4 py-2">{{ $ward->name }}</td>
                                        <td class="px-4 py-2">{{ $ward->name }}</td>

                                        <td class="p-4 text-right space-x-2">
                                            <a href="{{ Route('districts.wardEdit',$ward->id) }}"
                                                class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                                Edit
                                            </a>

                                            <form action="{{ Route('districts.wardDelete',$ward->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs"
                                                    onclick="return confirm('Delete this palika?')"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-center text-gray-500">
                                            No wards available
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-6 text-center text-gray-500 italic">
                        No Palikas Found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endforeach

</x-top-layout>
