<x-top-layout>

    @if($election && $election->count())
    {{-- <div class="flex flex-col items-center justify-center mt-10 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200 text-center">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">
            निर्वाचन परिणाम हेर्नुहोस्।
        </h2>
    </div>
        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="sticky top-0 z-10
                              bg-gradient-to-r from-indigo-600 to-blue-500
                              text-white">
                    <tr>
                        <th class="text-left px-4 py-3 border-b">Name</th>
                        <th class="text-left px-4 py-3 border-b">Date</th>
                        <th class="text-left px-4 py-3 border-b">Action</th>
                    </tr>
                </thead>

                <tbody class="   bg-white shadow-lg rounded-xl p-8 border border-gray-200 ">
                    @foreach ($election as $e)
                        <tr class=" border-b group hover:bg-indigo-50 transition text-lg">
                            <td class="px-4 py-3 border-b cursor-pointer">
                                {{ $e->title }}
                            </td>
                            <td class="px-4 py-3 border-b cursor-pointer">
                                {{ $e->election_date }}
                            </td>
                            <td class="px-4 py-3 border-b">
                                <a href="{{ route('elections.result', $e->id) }}"
                                   class="inline-block bg-blue-500 text-white px-3 py-1 text-sm rounded-md hover:bg-blue-600 transition">
                                    View Result
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
<div class="flex flex-col items-center justify-center mt-10 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200 text-center">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800">
        निर्वाचन परिणाम हेर्नुहोस्।
    </h2>
</div>

<div class="mt-5 space-y-4">
    @foreach ($election as $e)
        <div class="flex items-center justify-between
                    bg-white shadow-md rounded-lg p-4 border border-gray-200
                    hover:bg-indigo-50 transition">

            <!-- Name -->
            <div class="text-blue-700 font-medium">
                {{ $e->title }}
            </div>

            <!-- Date -->
            <div class="text-blue-700 font-medium">
                {{ $e->election_date }}
            </div>

            <!-- Action -->
            <div>
                <a href="{{ route('elections.result', $e->id) }}"
                   class="bg-blue-500 text-white px-3 py-1 font-medium rounded-md hover:bg-blue-600 transition whitespace-nowrap">
                    नतिजा हेर्नुहोस्
                </a>
            </div>

        </div>
    @endforeach
</div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center mt-10 mb-10 bg-white shadow-lg rounded-xl p-8 border border-gray-200 text-center">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                यहाँ कुनै डाटा भेटिएन।
            </h2>
            <p class="mt-2 text-gray-500 text-sm md:text-base">
                हालसम्म कुनै परिणाम फेला परेको छैन। तपाईंले खोजेको विवरण उपलब्ध भएपछि मात्र यहाँ देखाइनेछ।
            </p>
        </div>
    @endif

</x-top-layout>
