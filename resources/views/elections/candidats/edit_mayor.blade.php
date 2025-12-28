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
                {{ $mayor->citizen->name_nepali }} Data edit
            </a>
        </div>
    </header>
{{--  --}}
    <div class="max-w-5xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">
        <div class="relative h-56 group">
            <img src="{{$mayor->citizen->photo}}" alt="Cover" class="w-full h-full object-cover brightness-90 group-hover:brightness-100 transition-all duration-500"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
        </div>
        <div class="relative px-10 pb-10">
            <div class="absolute -top-24 left-10">
                <div class="relative">
                    <img src="{{$mayor->photo}}" alt="Avatar"class="w-44 h-44 rounded-full border-[6px] border-white shadow-2xl object-cover"/>

                    <div class="absolute bottom-3 right-3 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                        ✓
                    </div>
                </div>
            </div>

            <div class="pt-28">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">{{$mayor->citizen->name_nepali}}</h1>
                <p class="mt-2 text-lg font-semibold text-gray-700">{{$mayor->district->name_nepali}}, {{$mayor->palika->name}}</p>
            </div>
        </div>

        <div class="mt-8 mb-6 h-[2px] w-32 bg-gradient-to-r from-blue-600 to-green-500 rounded-full"></div>

        <form action="{{ Route('mayor.update',$mayor->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="number" name="citizen_id" value="{{ $mayor->citizen_id }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="district_id" value="{{ $mayor->district_id }}"  class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="palika_id" value="{{ $mayor->palika_id }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>

            <input type="number" name="election_id" value="{{ $mayor->election }}" class="hidden w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition" required>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Post</label>
                <select name="post"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
                    <option value="{{ $mayor->post }}">{{ $mayor->post }}</option>
                    <option value="Mayor">Mayor</option>
                    <option value="Deputy Mayor">Deputy Mayor</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Political Party</label>
                <input type="text" name="party" value="{{ $mayor->party }}"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition">
            </div>

            <div class="">
                <label class="block text-sm font-semibold text-gray-700">
                    Vision / Goals
                </label>
                <textarea name="goal" rows="10" value="{{ $mayor->goal }}"
                    class="w-full mt-2 p-4 border rounded-xl focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition">
                {{ $mayor->goal }}
                </textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Photo Upload</label>
                <input type="file" name="photo" value="{{ $mayor->photo }}"
                class="w-full mt-2 p-3 border rounded-lg hover:border-blue-500 transition">
            </div>

            <div class="md:col-span-2 text-center mt-6">
                <button type="submit"
                    class="w-full md:w-1/3 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition" onclick="return confirm('Are you sure you want to Register this record?');">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</x-defult_layout>
