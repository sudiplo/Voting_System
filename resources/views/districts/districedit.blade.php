<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('districts.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ District Management</a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">Update District</a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                <span class="text-indigo-600">{{ $district->name_nepali }}</span> District
            </h1>
            <p class="mt-2 text-gray-500">
                Click ➕ Add Palika button to add new palika
            </p>
        </div>
            <!-- ADD DISTRICT BUTTON -->
            <button id="add" data-dropdown-toggle="dropdown"
                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500
                  text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
                ➕ Add Palika
            </button>
        </div>

        <!-- ADD PALIKA DROPDOWN -->
        <div id="dropdown" class="hidden mt-6 w-full sm:w-[26rem] rounded-2xl border border-gray-200 bg-white shadow-lg" >
            <!-- Header -->
            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Add New Palika</h3>
                <p class="text-sm text-gray-500">Create a new palika under this district.</p>
            </div>
            <!-- Form -->
            <form action="{{ route('palika.add') }}" method="POST" class="p-5 space-y-4" onsubmit="return confirm('Are you sure you want to add this palika?')">
                @csrf
                <input type="hidden" name="district_id" value="{{ $district->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Palika Name
                    </label>
                    <input type="text" name="name" placeholder="e.g. Pokhara Metropolitan" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    <p class="mt-1 text-xs text-gray-500">Enter the official palika name.</p>
                </div>

                <div class="pt-3 border-t">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                        hover:bg-blue-700 active:scale-95
                        focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            Save Palika
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- ================= edit district section ================= -->
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">Edit </h3>
            </div>
        </div>
        <!-- UPDATE -->
        <div class="p-8">
            <form action="{{ Route('district.update',$district->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">District Name</label>
                    <input type="text" name="name" value="{{ $district->name }}"
                    class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">District Name(Nepali)</label>
                    <input type="text" name="name_nepali" value="{{ $district->name_nepali }}"
                    class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm" onclick="return confirm(' Do you want to update the data?')">
                        Update District
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-defult_layout>

