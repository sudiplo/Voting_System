<x-guest>
    <div class="relative mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Candidates Of {{ $election->title }}</h2>
        <p class="mt-2 text-gray-500">You can view the candidates profile click on view</p>
    </div>
    <!-- Search Form -->
    <form action="{{ Route('guest.candidate.search',$election->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        <!-- Address -->
        <div class="md:col-span-2 mt-1">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border">
                <!-- District -->
                <div class="p-2">
                    <label class="block text-sm font-semibold text-gray-600">जिल्ला</label>
                    <select id="districtSelect" name="district_id" class="w-full border rounded px-4 py-2" required>
                        <option value="">Select District</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name_nepali }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Palika -->
                <div class="p-2">
                    <label class="block text-sm font-semibold text-gray-700">गा॰पा॰/ न॰पा॰</label>
                    <select id="palikaSelect" name="palika_id" class="w-full border rounded px-4 py-2" disabled required>
                        <option value="">Select Palika</option>
                    </select>
                </div>

                <!-- Ward -->
                <div class="p-2">
                    <label class="block text-sm font-semibold text-gray-700">वडा नं.</label>
                    <select id="wardSelect" name="ward_id" class="w-full border rounded px-4 py-2" disabled required>
                        <option value="">Select Ward</option>
                    </select>
                </div>
                <div class="md:col-span-5 text-center mt-4">
                    <button type="submit" class="w-full md:w-1/3 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
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
                        palikaSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
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
                        wardSelect.innerHTML += `<option value="${w.id}">Ward ${w.number} - ${w.name}</option>`;
                    });
                } else {
                    wardSelect.disabled = true;
                }
            });
        </script>
    </form>

    <!-- ================= Grouped Candidate Display ================= -->
    @if($candidates->isNotEmpty())
        @php
            // Group candidates by their 'post' field
            $grouped = $candidates->groupBy('post');
            // Define the order of posts you want to display (optional)
            $postOrder = ['Mayor', 'Deputy Mayor', 'Ward Chairperson', 'Ward Member', 'Ward Member(Women)', 'Ward Member(Dalit)'];
        @endphp

        @foreach($postOrder as $post)
            @if(isset($grouped[$post]) && $grouped[$post]->count())
                <div class="mt-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $post }}</h2>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $grouped[$post]->count() }} candidates</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($grouped[$post] as $candidate)
                            <div class="relative bg-black rounded-xl overflow-hidden shadow-lg aspect-[3/4]">
                                <img src="{{ $candidate->photo }}" alt="Profile" class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                <div class="absolute bottom-0 w-full p-3 text-white">
                                    <h3 class="text-sm font-semibold truncate">{{ $candidate->citizen->name_nepali }}</h3>
                                    <p class="text-[11px] text-gray-300 truncate">{{ $candidate->party }}</p>
                                    <div class="mt-2 flex items-center justify-between text-[11px]">
                                        <span class="flex items-center gap-1">{{ $candidate->post }}</span>
                                        <a href="{{ Route('UsercandidateProfile', ['id' => $candidate->id, 'e_id' => $candidate->election]) }}"
                                           class="px-2 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white text-[10px] font-semibold">
                                            view
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p class="text-center mt-10 text-gray-500">No candidates available for the selected area.</p>
    @endif
</x-guest>
