<x-defult_layout>
    <div class="mb-12 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden">

        <!-- PALIKA HEADER -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-8 py-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-white">{{ $palika->name }}</h3>
                <p class="text-sm text-white/90">{{ $palika->district->name_nepali }}</p>
            </div>

        </div>
        <!-- UPDATE PALIKA -->
        <div class="p-8">
            <form action="{{ Route('palika.update',$palika->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('patch')

                <div class="p-2">
                    <label class="block text-sm font-semibold text-gray-600">जिल्ला</label>
                    <select
                        id="districtSelect"
                        name="district_id"
                        class="w-full border rounded px-4 py-2">
                        <option value="{{ $palika->district_id }}">{{ $palika->district->name_nepali }}</option>

                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">
                                {{ $district->name_nepali }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Palika Name</label>
                    <input type="text" name="name" id="name" value="{{ $palika->name }}" required
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

