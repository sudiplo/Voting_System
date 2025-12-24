<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('districts.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ District Management</a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">Update Voting Center</a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">{{ $center->name }}</span>
                </h1>
                <p class="mt-2 text-gray-500">
                    Update voting center details below
                </p>
            </div>
            <!-- DELETE BUTTON -->
            <div>
                <form action="{{ Route('districts.centerDelete',$center->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this voting center? This action cannot be undone.')">
                    @csrf
                    @method('delete')
                    <button id="add" data-dropdown-toggle="dropdown"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-red-500
                        text-white rounded-xl shadow-md hover:bg-red-600 transition">
                        ⚠️ Delete Voting Center
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- ================= edit section ================= -->
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden mt-5">
        <!--HEADER -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">{{ $center->name }}</h3>
                <p class="text-sm text-white/90">{{ $center->ward->palika->district->name_nepali }}</p>
            </div>

        </div>
        <!-- UPDATE -->
        <div class="p-8">
            <form action="{{ Route('center.update',$center->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')
                <input type="hidden" name="ward_id" value="{{ $center->ward_id }}">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Voting Center</label>
                    <input type="text" name="name" id="name" value="{{ $center->name }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm" onclick="return confirm(' Do you want to update the data?')">
                        Update Voting Center
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-defult_layout>
