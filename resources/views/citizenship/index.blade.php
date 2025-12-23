<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('citizen.view') }}" class="text-2xs text-gray-500 hover:text-blue-500">⌘ Citizen List</a>
        </div>
    </header>

    <!-- ===================== PAGE HEADER ===================== -->
    <div class="mb-8 bg-white shadow-lg rounded-2xl p-6 border border-gray-200
        flex flex-col md:flex-row md:items-center md:justify-between gap-6 mt-5">

        <!-- Left -->
        <div>
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                Citizenship <span class="text-indigo-600">Registry</span>
            </h1>
            <p class="mt-2 text-gray-500">
                Manage registered citizens and their official records
            </p>
            <!-- Search -->
            <form method="GET"
                action="{{ route('citizens.index') }}"
                class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto mt-2">

                <div class="relative w-full sm:w-96">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search name or citizenship number..."
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

        <!-- Action -->
        <a href="{{ Route('citizen.registerView') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500
                  text-white rounded-xl shadow-md hover:bg-emerald-600 transition">
            ➕ Register New
        </a>
    </div>

    <!-- ===================== TABLE ===================== -->
    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="sticky top-0 z-10
                              bg-gradient-to-r from-indigo-600 to-blue-500
                              text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Citizen</th>
                        <th class="px-6 py-4 text-left">Name (Nepali)</th>
                        <th class="px-6 py-4 text-left">Citizenship No.</th>
                        <th class="px-6 py-4 text-left">Gender</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($citizenships as $index => $c)
                        <tr class="group hover:bg-indigo-50 transition">
                            <td class="px-6 py-4">
                                <img
                                    src="{{ $c->photo }}"
                                    alt="photo"
                                    class="w-11 h-11 rounded-full object-cover
                                           ring-2 ring-white shadow-md"
                                >
                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $c->name_nepali }}
                            </td>

                            <td class="px-6 py-4 font-medium text-indigo-600">
                                {{ $c->citizenship_number }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $c->gender === 'Male' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                    {{ $c->gender }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right space-x-2 opacity-90 group-hover:opacity-100">
                                <a href="{{ route('citizen.profile', $c->id) }}"
                                   class="inline-flex items-center px-3 py-1.5
                                          bg-indigo-500 hover:bg-indigo-600
                                          text-white rounded-lg text-xs transition">
                                    View
                                </a>

                                <a href="{{ route('citizen.edit', $c->id) }}"
                                   class="inline-flex items-center px-3 py-1.5
                                          bg-yellow-400 hover:bg-yellow-500
                                          text-white rounded-lg text-xs transition">
                                    Edit
                                </a>

                                <form action="{{ route('citizen.delete', $c->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-3 py-1.5
                                               bg-red-500 hover:bg-red-600
                                               text-white rounded-lg text-xs transition"
                                        onclick="return confirm('Delete citizenship number: {{ $c->citizenship_number }} ?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <p class="text-gray-400 text-lg">
                                    🚫 No citizenship records found
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-defult_layout>
