<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">🗳️ Elections Management</a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">Update Election</a>
        </div>
    </header>

    <!-- ================= edit section ================= -->
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden mt-5">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-8 py-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">{{  $election->title }}</h3>
                {{-- <p class="text-sm text-white/90">{{ $palika->district->name_nepali }}</p> --}}
            </div>

        </div>
        <!-- UPDATE-->
        <div class="p-8">
            <form action="{{ Route('election.update',$election->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="name" id="name" value="{{  $election->title }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Election Date</label>
                    <input type="date" name="date" id="name" value="{{  $election->election_date }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm" onclick="return confirm(' Do you want to update the data?')">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-defult_layout>

