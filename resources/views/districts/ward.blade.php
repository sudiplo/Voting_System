 <!-- Palikas Table -->
<div class="p-6">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 text-sm">
                <th class="p-3 text-left font-semibold">Palika ID</th>
                <th class="p-3 text-left font-semibold">Palika Name</th>
                <th class="p-3 text-left font-semibold">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($district->palika as $p)
                <tr class="border-b group hover:bg-indigo-50 transition cursor-pointer">
                    <td class="p-3 text-gray-700">{{ $p->id }}</td>
                    <td class="p-3 font-medium text-gray-800 group-hover:text-indigo-700">
                        {{ $p->name }}
                    </td>
                    <td>
                        <!-- Toggle checkbox to show ward list -->
                        <label for="toggle-ward-{{ $p->id }}" class="cursor-pointer text-indigo-600 hover:text-indigo-800">View ward</label>
                        <input type="checkbox" id="toggle-ward-{{ $p->id }}" class="hidden peer" />

                        <!-- Ward List -->
                        <div class="peer-checked:block hidden mt-2 p-4 bg-indigo-50 rounded-lg">
                            <h3 class="text-sm font-semibold">Wards of {{ $p->name }}
                                {{-- add ward --}}
                                <div class="flex md:flex-row">
                                    <form action="{{route('ward.add')}} " method="post">
                                        @csrf
                                        <div class="flex md:flex-row space-x-3">
                                            <div class="mb-5">
                                            <input type="text" id="palika_id" name="palika_id" value="{{ $p->id  }}" class="hidden bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
                                        </div>
                                        <div class="mb-5">
                                            <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded focus:ring-brand focus:border-brand block w-30 px-2 py-1 shadow-md placeholder:text-body" placeholder="Add ward" required />
                                        </div>
                                        <div>
                                            <button type="submit" class="submitButton bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded cursor-pointer">Add</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </h3>
                            <ul class="list-disc pl-6 mt-2">
                                @forelse ($p->wards as $ward)
                                    <li class="text-gray-700">{{ $ward->name }}</li>
                                @empty
                                    <li class="text-gray-500">No wards available for this Palika.</li>
                                @endforelse
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-gray-500 italic text-center">
                        No Palikas Available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
