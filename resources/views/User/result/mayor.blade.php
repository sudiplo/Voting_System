<x-top-layout>

    <!-- PAGE HEADER -->
    <div class="relative mt-6 mb-12 bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-8 border border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">नगर प्रमुख</span>
                </h1>

                <p class="mt-3 text-gray-500 text-sm md:text-base max-w-xl">
                    <span class="font-medium text-gray-700">
                        {{ $palika->district->name_nepali }}, {{ $palika->name }}को मतदान परिणाम।
                    </span>
                </p>
            </div>

        </div>
    </div>
    <!-- Dropdown Button -->
    <button id="candidateDropdownButton" data-dropdown-toggle="candidateDropdown" data-dropdown-trigger="hover" class="inline-flex items-center justify-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 shadow font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" type="button">
        Select Position
        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 9-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div id="candidateDropdown" class="z-10 hidden bg-white border border-gray-200 rounded-lg shadow-lg w-44">
        <ul class="p-2 text-sm font-medium text-gray-600"
            aria-labelledby="candidateDropdownButton">

            <li>
                <a href="{{ Route('Usermayor.result', ['id' => $palika->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Mayor
                </a>
            </li>

            <li>
                <a href="{{ Route('UserDeputymayor.result', ['id' => $palika->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Deputy Mayor
                </a>
            </li>

        </ul>
    </div>
    <!-- ================= show data ================= -->
    <div class="mt-6 mb-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach ($candidate as $mayor)
        <div class=" w-full max-w-md mx-auto bg-white border border-gray-200 rounded-2xl shadow-lg p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mayor->post }} Candidate</h2>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="p-1 rounded-xl bg-indigo-500">
                        <img
                            src="{{ $mayor->photo }}"
                            alt="Profile Photo"
                            class="w-28 h-36 rounded-lg object-cover bg-white"
                        >
                    </div>
                </div>

                <div class="flex-1 text-sm space-y-2">
                    <div>
                        <span class="text-gray-500 text-xs">Name:</span>
                        <span class="font-semibold text-gray-800">{{ $mayor->citizen->name_nepali }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Party:</span>
                        <span class="font-semibold text-gray-700">{{ $mayor->party }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Region:</span>
                        <span class="font-semibold text-gray-700">{{ $mayor->district->name_nepali }}, {{ $mayor->palika->name }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 text-xs">Candidate Type:</span>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                            {{ $mayor->post }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-xs">Vote:</span>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                            {{ $mayor->vote }}
                        </span>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-200 my-4"></div>

            <a href="{{ Route('UsercandidateProfile',['id'=>$mayor->id,'e_id'=>$e->id]) }}" class="block w-full text-center px-4 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    View Full Profile
            </a>
        </div>
    @endforeach
    </div>

</x-top-layout>
