<x-guest>
    <div class="relative mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ $e->title }} Winner</h2>
        {{-- <p class="mt-2 text-gray-500">You can view the candidates profile click on view</p> --}}
    </div>
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

    {{-- result --}}
    <div class="mt-5 lg:col-span-2 bg-white rounded-2xl shadow">
        <div class="border-b px-6 py-4 font-semibold">
            {{ $e->title }} – Election Result of {{ $p->name }}, {{ $wa->name }}
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                    <tr>
                        <th class="text-left px-6 py-3">Name</th>
                        <th class="text-left px-6 py-3">Post</th>
                        <th class="text-left px-6 py-3">Gender</th>
                        <th class="text-left px-6 py-3">District</th>
                        <th class="text-left px-6 py-3">Palika</th>
                        <th class="text-left px-6 py-3">Ward</th>
                        <th class="text-left px-6 py-3">Votes</th>
                    </tr>
                </thead>
                <tbody class="divide-y">

                    {{-- Mayor --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($mayor && $mayor->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $mayor->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $mayor->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $mayor->post }}</td>
                            <td class="px-6 py-4">{{ $mayor->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $mayor->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $mayor->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $mayor->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $mayor->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>

                    {{-- Deputy Mayor --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($deputyMayor && $deputyMayor->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $deputyMayor->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $deputyMayor->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $deputyMayor->post }}</td>
                            <td class="px-6 py-4">{{ $deputyMayor->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $deputyMayor->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $deputyMayor->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $deputyMayor->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $deputyMayor->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>

                    {{-- Ward Chairperson --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($wardChairperson && $wardChairperson->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $wardChairperson->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $wardChairperson->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $wardChairperson->post }}</td>
                            <td class="px-6 py-4">{{ $wardChairperson->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardChairperson->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardChairperson->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardChairperson->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $wardChairperson->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>

                    {{-- Ward Member --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($wardMember && $wardMember->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $wardMember->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $wardMember->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $wardMember->post }}</td>
                            <td class="px-6 py-4">{{ $wardMember->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMember->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMember->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMember->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $wardMember->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>

                    {{-- Ward Member (Women) --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($wardMemberWomen && $wardMemberWomen->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $wardMemberWomen->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $wardMemberWomen->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $wardMemberWomen->post }}</td>
                            <td class="px-6 py-4">{{ $wardMemberWomen->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberWomen->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberWomen->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberWomen->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $wardMemberWomen->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>

                    {{-- Ward Member (Dalit) --}}
                    <tr class="group hover:bg-gray-100 transition">
                        @if($wardMemberDalit && $wardMemberDalit->candidate)
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('candidateProfile', ['id' => $wardMemberDalit->candidate_id, 'e_id' => $e->id]) }}">
                                    {{ $wardMemberDalit->candidate->citizen->name_nepali ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $wardMemberDalit->post }}</td>
                            <td class="px-6 py-4">{{ $wardMemberDalit->candidate->citizen->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberDalit->candidate->district->name_nepali ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberDalit->candidate->palika->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $wardMemberDalit->candidate->ward->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $wardMemberDalit->vote_count }}</td>
                        @else
                            <td colspan="7" class="px-6 py-4 text-gray-500">Not found</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-guest>
