<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('election.resultAdmin') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                📜 Result
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">Winner</a>
        </div>
    </header>
   <form action="{{ route('elections.winnerSearchAdmin',$e->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
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

</x-defult_layout>
