<x-top-layout>
    <div class="max-w-5xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">
      <a href="{{ Route('citizen.view') }}">Profile Update</a>
    </h1>

    <form action="{{ Route('citizen.update',$citizen->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- Full Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">नाम थर: </label>
            <input type="text" name="nepaliName" value="{{ old('nepaliName', $citizen->name_nepali) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition" placeholder="नेपाली मा ">
        </div>

        <!-- Full Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Full Name in English:</label>
            <input type="text" name="nameEnglish" value="{{ old('nameEnglish', $citizen->name_english) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition" placeholder="In English">
        </div>

        <!-- Citizenship Number -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">ना॰प्र॰नं॰:</label>
            <input type="number" name="citizenshipNumber" value="{{ old('citizenshipNumber', $citizen->citizenship_number) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition" placeholder="नागरिकताको नं.">
        </div>

        <!-- Father Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">बाबुको नाम थर :</label>
            <input type="text" name="fatherName" value="{{ old('fatherName', $citizen->father) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition">
        </div>

        <!-- Mother Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">आमाको नाम थर:</label>
            <input type="text" name="motherName" value="{{ old('motherName', $citizen->mother) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition">
        </div>

        <!-- Date of Birth -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">जन्म मितिः</label>
            <input type="date" name="dob" value="{{ old('dob', $citizen->dob) }}"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition">
        </div>

        <!-- Gender -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">
                लिङ्ग:
            </label>

            <select
                name="gender"
                class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
            >
                <option value="{{ old('gender', $citizen->gender) }}">{{ $citizen->gender }}</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>


        <!-- Card Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">
                नागरिकताको किसिम:
            </label>

            <select
                name="cardType"
                class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
            >
                <option value="{{ old('cardType', $citizen->type) }}">{{ $citizen->type }}</option>
                <option value="वंशज">वंशज</option>
                <option value="अंगीकृत">अंगीकृत</option>
                <option value="गैर आवासीय">गैर आवासीय</option>
                <option value="सम्मानार्थ">सम्मानार्थ</option>
            </select>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">
                स्थायी बासस्थानः
            </label>

            <div class="mt-2 p-3">
                <!-- District -->
                <div class="p-2">
                    <label class="block text-sm font-semibold text-gray-600">जिल्ला</label>
                    <select
                        id="districtSelect"
                        name="district_id"
                        class="w-full border rounded px-4 py-2"
                    >
                        <option value="{{ old('district_id', $citizen->district_id) }}">{{ $citizen->district->name_nepali }}</option>

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
                        class="w-full border rounded px-4 py-2">
                        <option value="{{ old('palika_id', $citizen->palika_id) }}">{{ $citizen->palika->name }}</option>
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
                        class="w-full border rounded px-4 py-2"                    >
                        <option value="{{ old('ward_id', $citizen->ward_id) }}">{{ $citizen->ward->name }}</option>
                    </select>
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


        <!-- partner Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">पती पत्नीको नामथर: </label>
            <input type="text" name="partner"
            class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition">
        </div>

        <!-- Photo Upload -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Photo Upload</label>
            <input type="file" name="photo" value="{{ old('photo', $citizen->photo) }}"
            class="w-full mt-2 p-3 border rounded-lg hover:border-blue-500 transition">
        </div>

        <!-- Submit Button -->
        <div class="md:col-span-2 text-center mt-4">
            <button type="submit"
            class="w-full md:w-1/3 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Save Citizenship Record
            </button>
        </div>

    </form>
  </div>


</x-top-layout>
