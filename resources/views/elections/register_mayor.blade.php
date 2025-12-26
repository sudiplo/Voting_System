<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                Elections Candidates
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                Register Mayor/Depty Mayor
            </a>
        </div>
    </header>
<!-- ===================== PAGE ===================== -->
    <div class="max-w-5xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-800">
                <span class="text-indigo-600">Registration</span> Form
            </h1>
            <p class="mt-2 text-gray-500">
                Official Mayor / Deputy Mayor Record
            </p>
        </div>

        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Citizenship Certificate</h2>
                <p class="text-sm text-gray-500">नेपाल सरकार</p>
            </div>

            <div class="w-24 h-28 border rounded-md">
                <img src="{{ $citizen->photo }}"
                    class="w-full h-full object-cover"
                    alt="Citizen Photo">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-500">Name (Nepali)</p>
                <p class="font-semibold text-gray-800">{{ $citizen->name_nepali }}</p>
            </div>

            <div>
                <p class="text-gray-500">Name (English)</p>
                <p class="font-semibold text-gray-800">{{ $citizen->name_english }}</p>
            </div>

            <div>
                <p class="text-gray-500">Citizenship Number</p>
                <p class="font-semibold text-indigo-600">{{ $citizen->citizenship_number }}</p>
            </div>

            <div>
                <p class="text-gray-500">Date of Birth</p>
                <p class="font-semibold">{{ $citizen->dob }}</p>
            </div>

            <div>
                <p class="text-gray-500">Gender</p>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                    {{ $citizen->gender == 'Male' ? 'bg-blue-100 text-blue-700' :
                    ($citizen->gender == 'Female' ? 'bg-pink-100 text-pink-700' :
                    'bg-gray-100 text-gray-700') }}">
                    {{ $citizen->gender }}
                </span>
            </div>

            <div>
                <p class="text-gray-500">Citizenship Type</p>
                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                    {{ $citizen->type }}
                </span>
            </div>

            <div>
                <p class="text-gray-500">Father's Name</p>
                <p class="font-semibold">{{ $citizen->father }}</p>
            </div>

            <div>
                <p class="text-gray-500">Mother's Name</p>
                <p class="font-semibold">{{ $citizen->mother }}</p>
            </div>

            <div>
                <p class="text-gray-500">Spouse Name</p>
                <p class="font-semibold">{{ $citizen->partner ?? '—' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Address</p>
                <p class="font-semibold">
                    {{ $citizen->district->name }},
                    {{ $citizen->palika->name }}-
                    {{ $citizen->ward->number }}
                    {{ $citizen->ward->name}}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 pt-4 border-t flex justify-between items-center text-xs text-gray-500">
            <p>Issued Date: {{ $citizen->created_at->format('d M Y') }}</p>
            <p>System Generated</p>
        </div>


        <form action="{{ Route('mayor.register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3">
            @csrf
            <input type="number" name="citizen_id" value="{{ $citizen->id }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="district_id" value="{{ $citizen->district_id }}"  class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="palika_id" value="{{ $citizen->palika_id }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="election_id" value="{{ $election->id }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Post</label>
                <select name="post"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
                    <option value="">Select Post</option>
                    <option value="Mayor">Mayor</option>
                    <option value="Depaty Mayor">Deputy Mayor</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Political Party</label>
                <input type="text" name="party"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
            </div>

            <div class="">
                <label class="block text-sm font-semibold text-gray-700">
                    Vision / Goals
                </label>
                <textarea name="goal" rows="10"
                    class="w-full mt-2 p-4 border rounded-xl focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    placeholder="Write detailed vision, plans, and goals (paragraphs or pages)..."
                    required></textarea>
            </div>

            <div class="md:col-span-2 text-center mt-6">
                <button type="submit"
                    class="w-full md:w-1/3 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition" onclick="return confirm('Are you sure you want to Register this record?');">
                    Save Record
                </button>
            </div>
        </form>
    </div>

</x-defult_layout>
