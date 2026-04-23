<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('voters.view') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ Voter List</a>
        </div>
    </header>
    <form action="{{ Route('voter.search') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        <!-- Address -->
            <div class="md:col-span-2 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border">
                    <!-- District -->
                    <div class="p-2">
                        <label class="block text-sm font-semibold text-gray-600">जिल्ला</label>
                        <select
                            id="districtSelect"
                            name="district_id"
                            class="w-full border rounded px-4 py-2" required
                        >
                            <option value="">Select District</option>

                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">
                                    {{ $district->name_nepali }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Palika -->
                    <div class="p-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            गा॰पा॰/ न॰पा॰
                        </label>
                        <select
                            id="palikaSelect"
                            name="palika_id"
                            class="w-full border rounded px-4 py-2"
                            disabled required
                        >
                            <option value="">Select Palika</option>
                        </select>
                    </div>

                    <!-- Ward -->
                    <div class="p-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            वडा नं.
                        </label>
                        <select
                            id="wardSelect"
                            name="ward_id"
                            class="w-full border rounded px-4 py-2"
                            disabled required
                        >
                            <option value="">Select Ward</option>
                        </select>
                    </div>
                    <div class="md:col-span-5 text-center mt-4">
                        <button type="submit"
                            class="w-full md:w-1/3 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <script>
                const districts = @json($districts);

                const districtSelect = document.getElementById('districtSelect');
                const palikaSelect = document.getElementById('palikaSelect');
                const wardSelect = document.getElementById('wardSelect');

                districtSelect.addEventListener('change', function () {
                    palikaSelect.innerHTML = '<option value="">Select Palika</option>';
                    wardSelect.innerHTML = '<option value="">Select Ward</option>';
                    wardSelect.disabled = true;

                    const district = districts.find(d => d.id == this.value);

                    if (district) {
                        palikaSelect.disabled = false;

                        district.palika.forEach(p => {
                            palikaSelect.innerHTML += `
                                <option value="${p.id}">${p.name}</option>
                            `;
                        });
                    } else {
                        palikaSelect.disabled = true;
                    }
                });

                palikaSelect.addEventListener('change', function () {
                    wardSelect.innerHTML = '<option value="">Select Ward</option>';

                    const district = districts.find(d => d.id == districtSelect.value);
                    const palika = district?.palika.find(p => p.id == this.value);

                    if (palika) {
                        wardSelect.disabled = false;

                        palika.wards.forEach(w => {
                            wardSelect.innerHTML += `
                                <option value="${w.id}">
                                    Ward ${w.number} - ${w.name}
                                </option>
                            `;
                        });
                    } else {
                        wardSelect.disabled = true;
                    }
                });
            </script>
    </form>

     {{-- =========================voter list==================================================================================== --}}
    <div class="mt-5 bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
        <div class="border-b px-6 py-4 font-semibold">
            @if(isset($d, $p, $w))
                Voter List of {{ $d->name_nepali }}, {{ $p->name }}, Ward {{ $w->number }}
            @else
                Voter List
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="sticky top-0 z-10
                              bg-gradient-to-r from-indigo-600 to-blue-500
                              text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Voter</th>
                        <th class="px-6 py-4 text-left">id</th>
                        <th class="px-6 py-4 text-left">Name </th>
                        <th class="px-6 py-4 text-left">email</th>
                        <th class="px-6 py-4 text-left">phone</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($voter as $v)
                        <tr class="group hover:bg-indigo-50 transition">
                            <td class="px-6 py-4">
                                <img
                                    src="{{ $v->photo }}"
                                    alt="photo"
                                    class="w-11 h-11 rounded-full object-cover
                                           ring-2 ring-white shadow-md"
                                >
                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $v->id }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $v->name }}
                            </td>

                            <td class="px-6 py-4 font-medium text-indigo-600">
                                {{ $v->email }}
                            </td>

                            <td class="px-6 py-4 font-medium text-indigo-600">
                                {{ $v->phone }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-2 opacity-90 group-hover:opacity-100">
                                <a href="{{ route('citizen.profile', $v->citizen->id) }}"
                                   class="inline-flex items-center px-3 py-1.5
                                          bg-indigo-500 hover:bg-indigo-600
                                          text-white rounded-lg text-xs transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <p class="text-gray-400 text-lg">
                                    🚫 No voter records found
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-defult_layout>
