<x-guest>


    <!-- ================= Vote Candidate Profile ================= -->
    <div class="max-w-4xl mx-auto mt-16 bg-white/90 backdrop-blur-2xl rounded-3xl shadow-[0_25px_80px_-20px_rgba(0,0,0,0.25)] overflow-hidden border border-gray-200">
        <div class="relative h-56 group">
            <img src="{{$candidate->citizen->photo}}" alt="Cover" class="w-full h-full object-cover brightness-90 group-hover:brightness-100 transition-all duration-500"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative px-10 pb-10">
            <div class="absolute -top-24 left-10">
                <div class="relative">
                    <img src="{{$candidate->photo}}" alt="Avatar"class="w-44 h-44 rounded-full border-[6px] border-white shadow-2xl object-cover"/>

                    <div class="absolute bottom-3 right-3 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                        ✓
                    </div>
                </div>
            </div>

            <div class="pt-28">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">{{$candidate->citizen->name_nepali}}</h1>
                    <span class="mt-2 text-lg font-semibold text-gray-700">{{$candidate->district->name_nepali}}, {{$candidate->palika->name}}</span>

                <div class="flex items-center gap-2 mt-4 text-sm text-gray-600">
                    <span class="font-medium">Gender</span>
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium"> {{$candidate->citizen->gender}}</span>
                </div>

                <div class="flex items-center gap-2 mt-4 text-sm text-gray-600">
                    <span class="font-medium">Political Party</span>
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium"> {{$candidate->party}}</span>
                </div>

                <div class="flex items-center gap-2 mt-4 text-sm text-gray-600">
                    <span class="font-medium">Educational Qualification</span>
                    <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-medium"> {{$candidate->education->level}}</span>
                </div>

                {{-- <div class="flex items-center gap-2 mt-4 text-sm text-gray-600">
                    <span class="font-medium">Vote</span>
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium"> {{$candidate->vote}}</span>
                </div> --}}

                <div class="flex items-center gap-3 mt-4 text-gray-600 text-sm">
                    <p class="mt-2 text-lg font-semibold text-gray-700">{{$candidate->post}} Candidate</p>

                </div>

                <div class="mt-8 mb-6 h-[2px] w-32 bg-gradient-to-r from-blue-600 to-green-500 rounded-full"></div>

                <div class="bg-gray-50/70 border border-gray-200 rounded-2xl p-6 shadow-inner">
                    <h2 class="text-lg font-bold text-gray-900 mb-3"> Vision & Commitment</h2>
                    <p class="text-gray-700 text-sm leading-relaxed">{!! nl2br(e($candidate->goal)) !!}</p>
                </div>
            </div>

        </div>
    </div>


</x-guest>
