<x-front>
    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full mx-auto space-y-6 transform transition-all duration-300 ease-in-out hover:scale-105">
        @csrf

        <h2 class="text-3xl font-semibold text-center text-gray-800">Welcome Back!</h2>
        <p class="text-center text-gray-600 text-sm">Please log in to your account</p>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="name@example.com" required autofocus />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="••••••••" required />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center">
            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-neutral-100 focus:ring-2 focus:ring-blue-300" required/>
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 transition" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
            <button type="submit" class="w-20 bg-blue-600 text-white py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none transition transform hover:scale-105">
                Login
            </button>
        </div>
    </form>

</x-front>
