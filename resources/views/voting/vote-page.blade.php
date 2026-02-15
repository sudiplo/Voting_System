<x-top-layout>

<form method="POST" action="{{ route('vote.submit') }}">
    @csrf

    @php
        $groupedCandidates = $Candidates->groupBy('post');
        $totalPosts = count($groupedCandidates);

        // Define colors for each post
        $colors = [
            'Mayor' => 'red',
            'Deputy Mayor' => 'green',
            'Ward Chairperson' => 'purple',
            'Ward Member' => 'blue',
            'Ward Member(Women)' => 'pink',
            'Ward Member(Dalit)' => 'yellow',
        ];
    @endphp

    <!-- ================= HEADER ================= -->
    <div class="sticky top-0 z-40 bg-white shadow-md p-5 mb-10 rounded-xl">
        <div class="flex justify-between items-center flex-wrap">
            <div>
                <h1 class="text-2xl font-bold text-blue-700">
                    Cast Your Vote
                </h1>
                <p class="text-sm text-gray-500">
                    Select one candidate for each position
                </p>
            </div>
            <div class="text-right mt-2 sm:mt-0">
                <div class="text-sm text-gray-600">Total Positions</div>
                <div class="font-semibold text-blue-700">{{ $totalPosts }}</div>
            </div>
        </div>
    </div>

    <!-- ================= POSITIONS ================= -->
    @foreach ($groupedCandidates as $post => $postCandidates)

        @php
            $color = $colors[$post] ?? 'gray';
        @endphp

        <div class="mb-16 p-6 rounded-2xl shadow-md border-l-8 border-{{ $color }}-500 bg-{{ $color }}-50">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">{{ $post }}</h2>
                <p class="text-sm text-gray-600 mt-1">Choose one candidate for {{ $post }}</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">

                @foreach ($postCandidates as $candidate)
                <label class="relative bg-white rounded-2xl overflow-hidden shadow-md cursor-pointer group transition transform hover:-translate-y-2 hover:shadow-xl">
                    <input type="radio" name="vote[{{ $post }}]" value="{{ $candidate->id }}" class="hidden peer" required>

                    <img src="{{ $candidate->photo }}"
                         class="w-full h-full object-cover aspect-[3/4] transition duration-300 group-hover:scale-110">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent peer-checked:bg-{{ $color }}-900/70 transition-all duration-300"></div>

                    <!-- Candidate Info -->
                    <div class="absolute bottom-0 w-full p-4 text-white">
                        <h3 class="font-semibold text-sm truncate">{{ $candidate->citizen->name_nepali }}</h3>
                        <p class="text-xs text-gray-300 truncate">{{ $candidate->party }}</p>
                        <div class="mt-3 flex justify-between items-center text-xs">
                            <span class="bg-white/20 px-2 py-1 rounded">{{ $candidate->post }}</span>
                            <a href="{{ route('UsercandidateProfile', ['id'=>$candidate->id,'e_id'=>$candidate->election]) }}" onclick="event.stopPropagation()"
                               class="bg-{{ $color }}-600 hover:bg-{{ $color }}-700 px-2 py-1 rounded text-white">
                                View
                            </a>
                        </div>
                    </div>

                    <!-- Selected Badge -->
                    <div class="absolute top-3 right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow hidden peer-checked:block">
                        ✓ Selected
                    </div>

                </label>
                @endforeach

            </div>
        </div>

    @endforeach

    <!-- ================= SUBMIT BUTTON ================= -->
    <div class="text-center mb-16">
        <button type="submit"
                class="bg-blue-700 hover:bg-blue-800 text-white px-10 py-3 rounded-full shadow-xl text-lg transition">
            Submit Vote
        </button>
    </div>

</form>

</x-top-layout>
