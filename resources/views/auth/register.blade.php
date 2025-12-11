<x-front>
    <div class="bg-[#efeff1] hover:bg-white p-10 shadow-xl rounded">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <label for="name" :value="__('Name')" class="block mb-2.5 text-xl font-medium text-heading">Name</label>
                <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>

            <div class="mb-2">
                <label for="email" :value="__('Email')" class="block mb-2.5 text-xl font-medium text-heading">Email</label>
                <input type="email" id="email" name="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="name@flowbite.com" required />
                <x-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="mb-2">
                <label for="phone" :value="__('phone')" class="block mb-2.5 text-xl font-medium text-heading">Phone</label>
                <input type="phone" id="phone" name="phone" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>

            <div class="mb-2">
                <label for="photo" class="block mb-2.5 text-xl font-medium text-heading">Photo</label>
                <input type="file" id="photo" name="photo" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-2">
                <label for="password" :value="__('password')" class="block mb-2.5 text-xl font-medium text-heading">Password</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>

            <div class="mb-2">
                <label for="password_confirmation" :value="__('Confirm Password')" class="block mb-2.5 text-xl font-medium text-heading">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
            </div>

            <div class="flex items-center justify-end mt-2">
                <a class=" text-black hover:text-blue-600 dark:hover:text-blue-600 rounded" href="{{ route('login') }}">
                    Already registered?
                </a>
                <div class="p-2">
                    <button class="bg-blue-500 text-white text-xl px-5 py-2 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Register</button>
                </div>
            </div>
        </form>
    </div>
</x-front>
