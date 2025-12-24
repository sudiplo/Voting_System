<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('districts.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ District Management</a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">Update Ward</a>
        </div>
    </header>


    <!-- PAGE HEADER -->
    <div class="mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">{{ $ward->name }}</span>
                </h1>
                <p class="mt-2 text-gray-500">
                    Click ➕ Add Palika button to add new voting center
                </p>
            </div>

            <!-- ADD DISTRICT BUTTON -->
            <button id="add" data-dropdown-toggle="dropdown" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
                ➕ Add Voting Center
            </button>
        </div>

        <!-- ADD CENTER DROPDOWN -->
        <div id="dropdown" class="hidden mt-6 w-full sm:w-[28rem] rounded-2xl border border-gray-200 bg-white shadow-lg" >
            <!-- Header -->
            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Add New Voting Center</h3>
                <p class="text-sm text-gray-500">Create a voting center under this ward.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('center.add') }}" method="POST" class="p-5 space-y-4" onsubmit="return confirm('Are you sure you want to add this voting center?')">
                @csrf
                <input type="hidden" name="ward_id" value="{{ $ward->id }}">
                <!-- Center Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Voting Center Name</label>
                    <input type="text" name="name" placeholder="e.g. Shree Janata Secondary School" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                            shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition">
                    <p class="mt-1 text-xs text-gray-500">Use the official or commonly known name.</p>
                </div>

                <!-- Actions -->
                <div class="pt-3 border-t">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        Add Voting Center
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= edit section ================= -->
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden mt-5">

        <!-- WARD HEADER -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">{{ $ward->name }}</h3>
                <p class="text-sm text-white/90">{{ $ward->palika->name }}, Ward Number {{ $ward->number }}</p>
            </div>

        </div>
        <!-- UPDATE WARD -->
        <div class="p-8">
            <form action="{{ Route('ward.update',$ward->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <input type="hidden" name="palika_id" value="{{ $ward->palika_id }}">
                </div>
                <div>
                    <label for="number" class="block text-sm font-medium text-gray-700">Ward Number</label>
                    <input type="text" name="number" id="number" value="{{ $ward->number }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Ward Name</label>
                    <input type="text" name="name" id="name" value="{{ $ward->name }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm" onclick="return confirm(' Do you want to update the data?')">
                        Update Ward
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-defult_layout>

