<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Elections Regions
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ Route('mayor.view',$palika->id) }}" class="text-2xs text-gray-500 hover:text-blue-500">
                Register Candidates
            </a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="relative mt-6 mb-12 bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-8 border border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    <span class="text-indigo-600">Depaty Mayor</span> Candidates
                </h1>

                <p class="mt-3 text-gray-500 text-sm md:text-base max-w-xl">
                    Registered Depaty Mayor candidates of
                    <span class="font-medium text-gray-700">
                        {{ $palika->district->name_nepali }}, {{ $palika->name }}
                    </span>
                </p>
            </div>

            <div class="flex items-center gap-3 bg-gray-100 p-2 rounded-xl shadow-inner">
                <a href="{{ Route('mayor.view', $palika->id) }}"
                class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        text-gray-600 hover:text-indigo-600 hover:bg-white hover:shadow">
                    Mayor
                </a>

                <a href="{{ Route('Deputy_mayor.view', $palika->id) }}"
                    class="px-5 py-2 rounded-lg text-sm font-semibold transition-all
                        bg-indigo-600 text-white shadow
                        hover:bg-indigo-700"
                >
                    Deputy Mayor
                </a>
            </div>

        </div>
    </div>

    <!-- ================= show data ================= -->
    @foreach ($mayor as $mayor)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div class=" w-full max-w-md mx-auto bg-white border border-gray-200 rounded-2xl shadow-lg p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mayor->post }} Candidate</h2>
                </div>
                <a href="" class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs transition">
                    Edit
                </a>
            </div>
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="p-1 rounded-xl bg-indigo-500">
                        <img
                            src="{{ $mayor->citizen->photo }}"
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

                </div>
            </div>

            <div class="border-t border-gray-200 my-4"></div>

            <a href="{{ Route('mayorProfile',$mayor->id) }}" class="block w-full text-center px-4 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    View Full Profile
            </a>
        </div>
    </div>

    @endforeach

</x-defult_layout>
