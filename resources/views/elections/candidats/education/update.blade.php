<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('education-degrees.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Education Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Update Education Degree
            </a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                <span class="text-indigo-600">{{ $edu->level }}</span> 
            </h1>
            <p class="mt-2 text-gray-500">
                Update the education degree details.
            </p>
        </div>

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
            <form action="{{ Route('education.update',$edu->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Education Degree</label>
                    <input type="text" name="level" value="{{ $edu->level }}"
                    class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-blue-400" required>
                </div>


                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm" onclick="return confirm(' Do you want to update the data?')">
                        Update Education Degree
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-defult_layout>