<x-front>
    <div class="bg-[#efeff1] hover:bg-white p-10 rounded shadow-xl">
        <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block mb-2.5 text-xl font-medium text-heading">Enter your email</label>
            <input type="email" id="email" name="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="name@gmail.com" required autofocus />
            <x-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <div class="p-4">
                    <button class="bg-blue-500 text-white px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Email Password Reset Link</button>
                </div>
        </div>
    </form>
    </div>
</x-front>
