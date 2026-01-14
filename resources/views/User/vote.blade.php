<x-top-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-2xl font-bold mb-4">Election Status</h1>

        @if($election && $today === $election->election_date)
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 mb-6 rounded">
                🗳️ Voting is open today! Cast your vote now.
            </div>

            <h2 class="text-xl font-semibold mb-2">Candidates:</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>Candidate 1</li>
                <li>Candidate 2</li>
                <li>Candidate 3</li>
            </ul>

    <!-- ================= show data ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach ($candidate as $mayor)
        <div class=" w-full max-w-md mx-auto bg-white border border-gray-200 rounded-2xl shadow-lg p-5">
            {{-- <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mayor->post }} Candidate</h2>
                </div>
                <a href="{{ Route('edit_candidate',['id' => $mayor->id, 'e_id' => $e->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs transition">
                    Edit
                </a>
            </div> --}}
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="p-1 rounded-xl bg-indigo-500">
                        <img
                            src="{{ $mayor->photo }}"
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
                    <div>
                        <span class="text-gray-500 text-xs">Vote:</span>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                            {{ $mayor->vote }}
                        </span>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-200 my-4"></div>


        </div>
    @endforeach
    </div>

        @elseif($election)
            <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 mb-6 rounded">
                ⏳ Voting will begin on <strong>{{ $election->election_date }}</strong> for <strong>{{ $election->title }}</strong>.
            </div>
        @else
            <div class="p-4 bg-gray-100 border-l-4 border-gray-400 text-gray-700 rounded">
                ❌ No upcoming elections.
            </div>
        @endif
    </div>
</x-top-layout>
