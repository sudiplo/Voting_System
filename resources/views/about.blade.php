<x-top-layout>
    <div class="bg-[#efeff1] hover:bg-white p-10 rounded shadow-xl">
        <form method="POST" action="{{ route('distric') }}" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="name" :value="__('Name')" class="block mb-2.5 text-xl font-medium text-heading">Name</label>
                <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>

            <div class="mb-5">
                <label for="name" :value="__('Name')" class="block mb-2.5 text-xl font-medium text-heading">Name in nepali</label>
                <input type="text" id="name_nepali" name="name_nepali" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>
            <div class="flex items-center justify-end mt-4">
                <div class="p-4">
                    <button class="bg-blue-500 text-white text-xl px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Login</button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid xl:grid-cols-4 gap-7 p-5 rounded px-15 py-15">
        @foreach ($district as $c)
        <div class="bg-[#e9eff5] hover:bg-[#d6e8f9] rounded p-4 text-center shadow-lg">
            {{ $c->id }}
            <div class="bg-[#f8f9f9] rounded p-10">
                <p class="font-bold text-2xl">{{ $c->name }}</p>
            </div>
            <div class="bg-[#f8f9f9] rounded p-10">
                <p class="font-bold text-2xl">{{ $c->name_nepali}}</p>
            </div>

             <div class="bg-[#eae6e6]">
                <form action="{{route('palika')}} " method="post" id="deleteCompany">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="block mb-2.5 text-xl font-medium text-heading">District Id:{{ $c->id }}</label>
                        <input type="text" id="district_id" name="district_id" value="{{ $c->id }}" class="hidden bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
                    </div>
                    <div class="mb-5">
                        <label for="name" :value="__('Name')" class="block mb-2.5 text-xl font-medium text-heading">Name</label>
                        <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
                    </div>
                    <button type="submit" class="submitButton bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded cursor-pointer">Add</button>
                </form>
             </div>
        </div>

        @endforeach

    </div>

        <div class="grid xl:grid-cols-2 gap-7 p-5 rounded px-15 py-15">
        @foreach ($palika as $c)
        <div class="bg-[#e9eff5] hover:bg-[#d6e8f9] rounded p-4 text-center shadow-lg">
            {{ $c->id }}
            <div class="bg-[#f8f9f9] rounded p-10">
                <p class="font-bold text-2xl">{{ $c->name }}</p>
            </div>
            <div class="bg-[#f8f9f9] rounded p-10">
                <p class="font-bold text-2xl">District: {{ $c->district->name }}</p>
            </div>

        </div>

        @endforeach

    </div>
</x-top-layout>
