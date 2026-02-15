<x-top-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-2xl font-bold mb-4">Election Status</h1>

        @if($election && $today === $election->election_date)
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 mb-6 rounded">
                🗳️ Voting is open today! Cast your vote now.
            </div>

            <a href="{{ Route('vote.request') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition">
                Send OTP to Vote
            </a>
            <div class="mt-6 max-w-md mx-auto bg-white shadow-lg rounded-xl p-6 border border-gray-200">

                <h2 class="text-xl font-semibold text-gray-800 text-center mb-4">
                    🔐 Enter OTP to Cast Vote
                </h2>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 border border-red-300 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Enter 6 Digit OTP
                        </label>

                        <input
                            type="text"
                            name="otp"
                            maxlength="6"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-center tracking-widest text-lg"
                            placeholder="••••••"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg transition duration-200">
                        Verify OTP
                    </button>
                </form>

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
