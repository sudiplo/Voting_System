<x-top-layout>

    <!-- ===================== PAGE HEADER ===================== -->
    <section class="px-10 flex flex-col items-center text-center fade-in">
        <h1 class="text-5xl font-bold text-gray-800 leading-tight">
            Register <span class="text-blue-600">Citizenship</span> Record
        </h1>
    </section>

    <!-- Top Bar -->
    <div class="mt-5 mb-10 bg-white shadow-xl rounded-2xl p-8 border border-gray-200 grid grid-cols-2 md:flex md:justify-between md:items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">District Management</h2>
            <p class="text-gray-600 mt-1">Manage districts, palikas and wards</p>
            <form method="GET"
                action="{{ route('citizens.index') }}"
                class="flex items-center gap-3 mb-6">
                <div class="relative w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or citizenship number"
                        class="w-full px-5 py-3 rounded-xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:outline-none transition" >
                </div>

                <button
                    type="submit"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Search
                </button>
            </form>
        </div>

        <div>
            <!-- New Register -->
            <a href="{{ Route('citizen.registerView') }}"
            class="px-5 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition">
                + Register New
            </a>
        </div>
    </div>
    <!-- ===================== TABLE ===================== -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gradient-to-r from-green-600 to-emerald-500 text-white">
                <tr>
                    <th class="px-6 py-3">S.No</th>
                    <th class="px-6 py-3">Name (Nepali)</th>
                    <th class="px-6 py-3">Citizenship Number</th>
                    <th class="px-6 py-3">Gender</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($citizenships as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <img src="{{ $c->photo }}" alt="photo" class="w-10 h-10 rounded-full object-cover mr-2 inline-block">
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $c->name_nepali }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-indigo-600">
                            {{ $c->citizenship_number }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-indigo-600">
                            {{ $c->gender }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                             <a href="{{ route('citizen.profile', $c->id) }}"
                               class="inline-flex items-center px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded text-xs">
                                View
                            </a>

                            <a href="{{ route('citizen.edit', $c->id) }}"
                               class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                Edit
                            </a>

                            <form action="{{ route('citizen.delete', $c->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs"
                                    onclick="return confirm('Are you sure you want to delete this record? citizenship number[{{ $c->citizenship_number }}]');">
                                    Delete
                                </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                            No record available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-top-layout>
