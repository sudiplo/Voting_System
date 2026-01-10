<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <div class="relative mt-5 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                    Elections <span class="text-indigo-600">Management</span>
                </h1>
                <p class="mt-2 text-gray-500">
                    Election records details overview and Register new Election.
                </p>
                <!-- Search -->
                <form method="GET" action="{{ Route('elections.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">
                    <div class="relative w-full sm:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search Election"
                            class="w-full pl-5 pr-10 py-3 rounded-xl border border-gray-300
                                shadow-sm focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500 outline-none transition"
                        />
                        <span class="absolute right-4 top-3 text-gray-400">🔍</span>
                    </div>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl
                            hover:bg-indigo-700 shadow-md transition">
                        Search
                    </button>
                </form>
            </div>

            <button id="add" data-dropdown-toggle="dropdown"
                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500
                       text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
                ➕ Register New Election
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
                    Register New Election
                </h3>
                <p class="text-sm text-gray-500">
                    Enter Election details and Election Date.
                </p>
            </div>

            <form method="POST"
                  action="{{ Route('elections.create') }}"
                  class="p-5 space-y-4"
                  onsubmit="return confirm('Are you sure you want to add this district?')">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Title of Election
                    </label>
                    <input type="text" name="name" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Election Date
                    </label>
                    <input type="date" name="date" required
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

    <!-- ===================== TABLE ===================== -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="sticky top-0 z-10
                              bg-gradient-to-r from-indigo-600 to-blue-500
                              text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Election Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($elections as $election)
                        <tr class="group hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $election->title }}
                            </td>

                            <td class="px-6 py-4 font-medium text-indigo-600">
                                {{ $election->election_date }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-2 opacity-90 group-hover:opacity-100">
                                <a href="{{ Route('elections.view',$election->id) }}"
                                   class="inline-flex items-center px-3 py-1.5
                                          bg-indigo-500 hover:bg-indigo-600
                                          text-white rounded-lg text-xs transition">
                                    View
                                </a>

                                <a href="{{ Route('election.editView', $election->id) }}"
                                   class="inline-flex items-center px-3 py-1.5
                                          bg-yellow-400 hover:bg-yellow-500
                                          text-white rounded-lg text-xs transition">
                                    Edit
                                </a>

                                <form action="{{ Route('election.delete',$election->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-3 py-1.5
                                               bg-red-500 hover:bg-red-600
                                               text-white rounded-lg text-xs transition"
                                        onclick="return confirm('Do you want to delete?')">
                                        Delete
                                    </button>
                                </form>
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

</x-defult_layout>
