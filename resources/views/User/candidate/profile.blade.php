<x-top-layout>

    <!-- ================= Vote Candidate Profile ================= -->
    <div class="max-w-5xl mx-auto bg-white/90 backdrop-blur-2xl rounded-3xl
                shadow-[0_25px_80px_-20px_rgba(0,0,0,0.25)]
                overflow-hidden border border-gray-200">

        <!-- Cover -->
        <div class="relative h-56 group">
            <img src="{{ $candidate->citizen->photo }}"
                 alt="Cover"
                 class="w-full h-full object-cover brightness-90
                        group-hover:brightness-100 transition-all duration-500"/>

            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative px-10 pb-10">

            <!-- Avatar -->
            <div class="absolute -top-24 left-10">
                <div class="relative">
                    <img src="{{ $candidate->photo }}"
                         alt="Avatar"
                         class="w-44 h-44 rounded-full border-[6px] border-white
                                shadow-2xl object-cover"/>

                    <div class="absolute bottom-3 right-3 bg-green-600
                                text-white rounded-full px-2 py-1 text-sm shadow-lg">
                        ✓ Verified
                    </div>
                </div>
            </div>

            <!-- Main Info -->
            <div class="pt-28">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                    {{ $candidate->citizen->name_nepali }}
                </h1>

                <p class="mt-2 text-lg font-semibold text-gray-700">
                    {{ $candidate->district->name_nepali }},
                    {{ $candidate->palika->name }}
                </p>

                <!-- Gender -->
                <div class="flex flex-wrap items-center gap-3 mt-5 text-sm">
                    <span class="font-medium text-gray-600">Gender</span>
                    <span class="inline-flex items-center gap-2
                                 bg-blue-100 text-blue-700
                                 px-4 py-1.5 rounded-full font-semibold">
                        {{ $candidate->citizen->gender }}
                    </span>
                </div>

                <!-- Educational Qualification -->
                <div class="flex flex-wrap items-center gap-3 mt-5 text-sm">
                    <span class="font-medium text-gray-600">Educational Qualification</span>
                    <span class="inline-flex items-center gap-2
                                 bg-blue-100 text-blue-700
                                 px-4 py-1.5 rounded-full font-semibold">
                        {{$candidate->education->level}}
                    </span>
                </div>

                <!-- Party -->
                <div class="flex flex-wrap items-center gap-3 mt-5 text-sm">
                    <span class="font-medium text-gray-600">Political Party</span>
                    <span class="inline-flex items-center gap-2
                                 bg-blue-100 text-blue-700
                                 px-4 py-1.5 rounded-full font-semibold">
                        {{ $candidate->party }}
                    </span>
                </div>

                <!-- Post -->
                <p class="mt-4 text-lg font-semibold text-gray-700">
                    {{ $candidate->post }} Candidate
                </p>

                <!-- Divider -->
                <div class="mt-8 mb-6 h-[3px] w-36
                            bg-gradient-to-r from-blue-600 to-green-500
                            rounded-full"></div>

                <!-- Vision -->
                <div class="bg-gray-50/70 border border-gray-200
                            rounded-2xl p-6 shadow-inner">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">
                        Vision & Commitment
                    </h2>

                    <p class="text-gray-700 text-sm leading-relaxed">
                        {!! nl2br(e($candidate->goal)) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-top-layout>
