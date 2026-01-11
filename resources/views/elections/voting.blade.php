<x-defult_layout>
    <h1>
    @if($election && $today === $election->election_date)
        You can vote today!<br>
        Candidates:
        <ul>
            <li>Candidate 1</li>
            <li>Candidate 2</li>
            <li>Candidate 3</li>
        </ul>
    @elseif($election)
        Voting will begin on {{ $election->election_date }}{{ $election->title }}
    @else
        No upcoming elections.
    @endif
</h1>
</x-defult_layout>
