<x-top-layout>
   <form action="{{ route('elections.winnerSearch',$e->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        <!-- Address -->
            <div class="md:col-span-2 mt-4">
                <div class="border-b px-6 py-4">
                    <h2 class="font-semibold text-gray-800">{{ $d->name_nepali }}, {{ $p->name }}, {{ $wa->name }}</h2>
                </div>
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
    {{-- <div class="mt-5 lg:col-span-2 bg-white rounded-2xl shadow">
        <div class="border-b px-6 py-4 font-semibold">
            {{ $p->name }}, {{ $wa->name }}
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-500   text-white">
                    <tr>
                        <th class="text-left px-6 py-3">Name</th>
                        <th class="text-left px-6 py-3">post</th>
                        <th class="text-left px-6 py-3">gender</th>
                        <th class="text-left px-6 py-3">Vote</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($mayor)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$mayor->id,'e_id'=>$e->id]) }}">{{ $mayor->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $mayor->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $mayor->citizen->gender}}
                        </td>
                        <td>{{ $mayor->vote }}</td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($deputyMayor)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$deputyMayor->id,'e_id'=>$e->id]) }}">{{ $deputyMayor->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $deputyMayor->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $deputyMayor->citizen->gender}}
                        </td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($wardChairperson)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$wardChairperson->id,'e_id'=>$e->id]) }}">{{ $wardChairperson->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $wardChairperson->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $wardChairperson->citizen->gender}}
                        </td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($wardMember)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$wardMember->id,'e_id'=>$e->id]) }}">{{ $wardMember->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $wardMember->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $wardMember->citizen->gender}}
                        </td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($wardMemberWomen)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$wardMemberWomen->id,'e_id'=>$e->id]) }}">{{ $wardMemberWomen->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $wardMemberWomen->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $wardMemberWomen->citizen->gender}}
                        </td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                    <tr class="group hover:bg-gray-100 transition">
                    @if ($wardMemberDalit)
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <a href="{{ Route('UsercandidateProfile',['id'=>$wardMemberDalit->id,'e_id'=>$e->id]) }}">{{ $wardMemberDalit->citizen->name_nepali }}</a>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $wardMemberDalit->post }}
                        </td>
                        <td class="class="px-6 py-4 font-semibold text-gray-800"">
                            {{ $wardMemberDalit->citizen->gender}}
                        </td>
                    @else
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            not found
                        </td>
                    @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}

    {{--  --}}
     <div class="mt-5 lg:col-span-2 bg-white rounded-2xl shadow">
        <div class="border-b px-6 py-4 font-semibold text-lg">
            🏆 Election Winners – {{ $p->name }}, {{ $wa->name }}
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                    <tr>
                        <th class="text-left px-6 py-3">Position</th>
                        <th class="text-left px-6 py-3">Winner Name</th>
                        <th class="text-left px-6 py-3">Gender</th>
                        <th class="text-left px-6 py-3">Votes</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    {{-- Mayor --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Mayor</td>
                        <td class="px-6 py-4">
                            @if($mayor)
                                <a href="{{ route('UsercandidateProfile', ['id' => $mayor->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $mayor->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $mayor->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $mayor->vote_count ?? 0 }}</td>
                    </tr>

                    {{-- Deputy Mayor --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Deputy Mayor</td>
                        <td class="px-6 py-4">
                            @if($deputyMayor)
                                <a href="{{ route('UsercandidateProfile', ['id' => $deputyMayor->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $deputyMayor->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $deputyMayor->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $deputyMayor->vote_count ?? 0 }}</td>
                    </tr>

                    {{-- Ward Chairperson --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Ward Chairperson</td>
                        <td class="px-6 py-4">
                            @if($wardChairperson)
                                <a href="{{ route('UsercandidateProfile', ['id' => $wardChairperson->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $wardChairperson->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $wardChairperson->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $wardChairperson->vote_count ?? 0 }}</td>
                    </tr>

                    {{-- Ward Member --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Ward Member</td>
                        <td class="px-6 py-4">
                            @if($wardMember)
                                <a href="{{ route('UsercandidateProfile', ['id' => $wardMember->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $wardMember->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $wardMember->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $wardMember->vote_count ?? 0 }}</td>
                    </tr>

                    {{-- Ward Member (Women) --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Ward Member (Women)</td>
                        <td class="px-6 py-4">
                            @if($wardMemberWomen)
                                <a href="{{ route('UsercandidateProfile', ['id' => $wardMemberWomen->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $wardMemberWomen->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $wardMemberWomen->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $wardMemberWomen->vote_count ?? 0 }}</td>
                    </tr>

                    {{-- Ward Member (Dalit) --}}
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">Ward Member (Dalit)</td>
                        <td class="px-6 py-4">
                            @if($wardMemberDalit)
                                <a href="{{ route('UsercandidateProfile', ['id' => $wardMemberDalit->candidate_id, 'e_id' => $e->id]) }}" class="text-blue-600 hover:underline">
                                    {{ $wardMemberDalit->candidate->citizen->name_nepali ?? 'Unknown' }}
                                </a>
                            @else
                                <span class="text-gray-400">Not declared</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $wardMemberDalit->candidate->citizen->gender ?? '-' }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $wardMemberDalit->vote_count ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-top-layout>
