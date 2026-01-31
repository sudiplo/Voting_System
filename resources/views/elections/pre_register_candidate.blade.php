<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('Admin.dashboard') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                📊 System Dashboard
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ route('election.register') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                👤 Register Candidate
            </a>
        </div>
    </header>

    <!-- STATS GRID -->
    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- ACTIVE ELECTIONS -->
        <div class="group bg-white rounded-2xl shadow-sm p-6 transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-1 border border-gray-100">
            <a href="{{ Route('elections.index') }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 group-hover:text-emerald-600 transition">
                            Active Elections
                        </p>
                        <p class="text-3xl font-bold text-emerald-600">
                            {{ $ActiveElections }}
                        </p>
                    </div>
                    <div class="text-4xl transform transition duration-300 group-hover:scale-110">
                        ✅
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- ================= Election Register Form ================= -->
    <div class="mt-10 border border-gray-200 bg-white shadow-2xl rounded-2xl w-full ">
        <div class="p-5 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                Register New Candidate
            </h3>
            <p class="text-sm text-gray-500">
                Choose The Election details and Enter the Information Below to Register a New Candidate
            </p>
        </div>

        <form method="GET" action="{{ route('register_candidate.index') }}" class="p-5 space-y-4" onsubmit="return confirm('Are you sure you want to add this district?')">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title of Election
                </label>
                <select name="election_id" class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition">
                    <option value="">Select Election</option>
                    @foreach ($election as $elections )
                        <option value="{{ $elections->id }}">{{ $elections->title }}</option>

                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Citizenship Number
                </label>
                <input type="text" name="search" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                💾 Register
            </button>
        </form>
    </div>
</x-defult_layout>
