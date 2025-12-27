<x-defult_layout>
    <!-- ================= current location ================= -->
    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="{{ Route('elections.index') }}" class="text-2xs text-gray-500 hover:text-blue-500">
                🗳️ Elections Management
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Elections Regions
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="" class="text-2xs text-gray-500 hover:text-blue-500">
                Register Candidates
            </a>
            <p class="text-2xs text-gray-500">|</p>
            <a href="{{ Route('mayorProfile',$mayor->id) }}" class="text-2xs text-gray-500 hover:text-blue-500">
                {{ $mayor->citizen->name_nepali }} Profile
            </a>
        </div>
    </header>

    <!-- ================= profile section ================= -->
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow overflow-hidden">

        <!-- Cover Image -->
        <div class="relative h-48">
        <img
            src="{{$mayor->citizen->photo}}"
            alt="Cover"
            class="w-full h-full object-cover"
        />

        <!-- Edit Button -->
        <button class="absolute top-4 right-4 bg-white p-2 rounded-full shadow">
            ✎
        </button>
        </div>

        <!-- Profile Section -->
        <div class="relative px-6 pb-6">

        <!-- Avatar -->
        <div class="absolute -top-16 left-6">
            <img
            src="{{$mayor->citizen->photo}}"
            alt="Avatar"
            class="w-32 h-32 rounded-full border-4 border-white object-cover"
            />
        </div>

        <!-- Content -->
        <div class="pt-20">
            <h1 class="text-2xl font-bold text-gray-900">
            {{$mayor->citizen->name_nepali}}
            </h1>

            <p class="text-sm text-gray-600 mt-1">
            {{$mayor->post}} Candidate
            </p>

            <!-- Location -->
            <div class="flex items-center gap-2 mt-3 text-sm text-blue-600">
            <span>🏛️</span>
            <span>{{$mayor->district->name_nepali}}, {{$mayor->palika->name}}</span>
            </div>

            <!-- Bio -->
            <p class="mt-4 text-gray-600 text-sm leading-relaxed max-w-2xl">
            {{ $mayor->goal }}
            </p>
        </div>

        </div>
    </div>
</x-defult_layout>
