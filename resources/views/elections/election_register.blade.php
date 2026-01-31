<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('election.register') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Election Register
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
                            Total Elections
                        </p>
                        <p class="text-3xl font-bold text-emerald-600">
                            {{ $totalElections }}
                        </p>
                    </div>
                    <div class="text-4xl transform transition duration-300 group-hover:scale-110">
                        ✅
                    </div>
                </div>
            </a>
        </div>

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
                Register New Election
            </h3>
            <p class="text-sm text-gray-500">
                Enter Election details and Election Date.
            </p>
        </div>

        <form method="POST" action="{{ Route('elections.create') }}" class="p-5 space-y-4" onsubmit="return confirm('Are you sure you want to add this district?')">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title of Election
                </label>
                <input type="text" name="name" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Election Date
                </label>
                <input type="date" name="date" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                💾 Register
            </button>
        </form>
    </div>
</x-defult_layout>
