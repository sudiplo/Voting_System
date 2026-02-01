<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('Admin.dashboard') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                📊 System Dashboard
            </a>
        </div>
    </header>



    <!-- STATS GRID -->
    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- TOTAL ELECTIONS -->
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
        <!-- ACTIVE ELECTIONS -->
        <div class="group bg-white rounded-2xl shadow-sm p-6 transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-1 border border-gray-100">
            <a href="{{ route('Admin.dashboard') }}">
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

        <!-- REGISTERED CITIZENS -->
        <div class="group bg-white rounded-2xl shadow-sm p-6 transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-1 border border-gray-100">
            <a href="{{ Route(name: 'citizen.view') }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 group-hover:text-indigo-600 transition">
                            Registered Citizens
                        </p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ $totalCitizens }}
                        </p>
                    </div>
                    <div class="text-4xl transform transition duration-300 group-hover:scale-110">
                        👥
                    </div>
                </div>
            </a>
        </div>

        <!-- REGISTERED VOTERS -->
        <div class="group bg-white rounded-2xl shadow-sm p-6 transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-1 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 group-hover:text-blue-600 transition">
                        Registered Voters
                    </p>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ $totalUsers }}
                    </p>
                </div>
                <div class="text-4xl transform transition duration-300 group-hover:scale-110">
                    📥
                </div>
            </div>
        </div>

    </div>


    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- RECENT ELECTIONS -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow">
            <div class="border-b px-6 py-4">
                <h2 class="font-semibold text-gray-800">Recent Elections</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="text-left px-6 py-3">Election Name</th>
                            <th class="text-left px-6 py-3">Election Date</th>
                            <th class="text-left px-6 py-3">Status</th>
                            <th class="text-left px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($elections as $election)
                            <tr class="group hover:bg-gray-100 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $election->title }}
                                </td>

                                <td class="px-6 py-4 font-medium text-indigo-600">
                                    {{ $election->election_date }}
                                </td>

                                <td class="px-6 py-4 font-medium {{ $election->status == 'process' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $election->status }}
                                </td>


                                <td class="px-6 py-4 text-right space-x-2 opacity-90 group-hover:opacity-100">
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $endDate = \Carbon\Carbon::parse($election->election_date)->addDay();
                                    @endphp

                                    @if ($today->greaterThanOrEqualTo($endDate))
                                        <form action="{{ Route('election.update', $election->id) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('patch')
                                            <input type="text" name="name" id="name" value="{{  $election->title }}" hidden required>
                                            <input type="date" name="date" id="date" value="{{  $election->election_date }}" hidden required>
                                            <input type="text" id="end" name="status" value="end" hidden required>

                                            <div>
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs transition" onclick="return confirm('Do you want to end the election?')">
                                                    Election End
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <a href="{{ Route('elections.view',$election->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-xs transition">
                                            View
                                        </a>

                                        <a href="{{ Route('election.editView', $election->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs transition">
                                            Edit
                                        </a>
                                    @endif


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center text-gray-400">
                                    🚫 No Election records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SYSTEM ACTIVITY -->
        <div class="bg-white rounded-2xl shadow">
            <div class="border-b px-6 py-4">
                <h2 class="font-semibold text-gray-800">System Activity</h2>
            </div>

            <ul class="divide-y text-sm">
                <a href="{{ Route('election.register') }}" class="px-6 py-4 flex hover:bg-gray-100 transition items-start gap-3">
                    <span>🗳️</span>
                    <div>
                        <p class="font-medium">New Election Register</p>
                    </div>
                </a>

                <a href="{{ Route('candidates.index') }}" class="px-6 py-4 flex hover:bg-gray-100 transition items-start gap-3">
                    <span>👤</span>
                    <div>
                        <p class="font-medium">New Candidates Register</p>
                    </div>
                </a>

                <a href="{{ Route('citizen.registerView') }}" class="px-6 py-4 flex hover:bg-gray-100 transition items-start gap-3">
                    <span>👤</span>
                    <div>
                        <p class="font-medium">Citizen register</p>
                    </div>
                </a>
            </ul>
        </div>

    </div>

    {{-- <!-- FOOTER NOTE -->
    <div class="mt-10 text-center text-xs text-gray-400">
        Digital Voting System • Admin Console • Version 1.0
    </div> --}}


</x-defult_layout>

