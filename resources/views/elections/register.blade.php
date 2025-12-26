<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Elections Candidates
            </a>
        </div>
    </header>


    <!-- PAGE HEADER -->
    <div class="relative mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    Elections <span class="text-indigo-600">Candidates</span>
                </h1>
                <p class="mt-2 text-gray-500">
                    Election Candidats records details overview and Register new Candidates.
                </p>
            </div>

            <button id="add" data-dropdown-toggle="dropdown"
                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500
                       text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
                ➕ Register New Mayor/Depty Mayor
            </button>
        </div>

        <!-- ADD DROPDOWN -->
        <div id="dropdown"
             class="hidden absolute right-8 top-full mt-4
                    w-full sm:w-[28rem]
                    rounded-2xl border border-gray-200
                    bg-white shadow-2xl z-50">

            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    Register New  Mayor/ Depty Mayor Candidate
                </h3>
                <p class="text-sm text-gray-500">
                    Enter Citizenship Number to Serch the Candidate details and Register.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('register_mayor.index',$election->id) }}" class="p-5 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Citizenship Number
                    </label>
                    <input type="text" name="search" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2
                               rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                               hover:bg-blue-700 transition">
                    💾 Register
                </button>
            </form>
        </div>
    </div>
</x-defult_layout>
