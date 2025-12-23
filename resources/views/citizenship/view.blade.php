<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('citizen.view') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ Citizen List</a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">{{ $citizen->name_nepali }} Profile</a>
        </div>
    </header>
<!-- ===================== PAGE HEADER ===================== -->
    <section class="px-10 flex flex-col items-center text-center fade-in mt-5">
        <h1 class="text-5xl font-bold text-gray-800 leading-tight">
             <span class="text-blue-600">{{ $citizen->name_nepali }}</span> Profile
        </h1>
    </section>


    <div class="max-w-3xl mx-auto bg-white border border-gray-300 rounded-xl shadow-lg p-6 mt-5">
        <!-- Header -->
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Citizenship Certificate</h2>
                <p class="text-sm text-gray-500">नेपाल सरकार</p>
            </div>

            <!-- Photo -->
            <div class="w-24 h-28 border rounded-md">
                <img src="{{ $citizen->photo }}"
                    class="w-full h-full object-cover"
                    alt="Citizen Photo">
            </div>
        </div>

        <!-- Body -->
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
    </div>

</x-defult_layout>
