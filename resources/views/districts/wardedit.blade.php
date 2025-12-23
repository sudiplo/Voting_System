<x-defult_layout>
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden">

        <!-- WARD HEADER -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-8 py-6 flex justify-between items-center">
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
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm">
                        Update Ward
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-defult_layout>

