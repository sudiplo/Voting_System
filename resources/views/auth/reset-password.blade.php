<x-front>
    <form method="POST" action="{{ route('password.store') }}" class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full mx-auto space-y-6 transform transition-all duration-300 ease-in-out hover:scale-105">
        @csrf
        <h2 class="text-3xl font-semibold text-center text-gray-800">Reset Password</h2>
        <p class="text-center text-gray-600 text-sm">Enter the email to reset your password</p>
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" :value="old('email', $request->email)" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="name@example.com" required autofocus autocomplete="username" />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" id="password" class="block mt-1 w-full" name="password" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="••••••••" required autocomplete="new-password"/>
        </div>
        {{-- Confirm Password --}}
         <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="password_confirmation" class="block mt-1 w-full" name="password_confirmation" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="••••••••" required autocomplete="new-password" />
            <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center">
            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-neutral-100 focus:ring-2 focus:ring-blue-300" required/>
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none transition transform hover:scale-105">
               Reset Password
            </button>
        </div>
    </form>
</x-front>
