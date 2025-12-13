<x-front>
        <div class="bg-[#efeff1] hover:bg-white p-10 rounded shadow-xl">
        <form method="POST" action="{{ route('login') }}" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2.5 text-xl font-medium text-heading">Email</label>
                <input type="email" id="email" name="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="name@gmail.com" required />
                <x-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2.5 text-xl font-medium text-heading">Password</label>
                <input type="password" id="password" name="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="••••••••" required />
            </div>
            <label for="remember" class="flex items-center mb-5">
                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" required />
                <p class="ms-2 text-sm font-medium text-heading select-none">I agree with the <a href="#" class="text-fg-brand hover:underline">terms and conditions</a>.</p>
            </label>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class=" text-black hover:text-blue-600 dark:hover:text-blue-600 rounded" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <div class="p-4">
                    <button class="bg-blue-500 text-white text-xl px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center space-x-2">Login</button>
                </div>
            </div>
        </form>
    </div>
</x-front>
