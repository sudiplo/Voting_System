<x-defult_layout>
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
</x-defult_layout>
