<x-front>
    <div class="bg-white shadow-2xl rounded-lg max-w-md mx-auto mt-16 p-10 transform transition-all duration-300 ease-in-out hover:scale-105">
        <p class="text-2xl font-semibold text-center text-gray-800 mb-6">Forgot Password?</p>
        <p class="text-center text-gray-600 mb-8">No worries, we'll send you reset instructions shortly.</p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="relative">
                <label for="email" class="text-sm font-medium text-gray-700 block mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full p-3 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" placeholder="Enter your email" required autofocus />
                <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-md shadow-md hover:bg-blue-600 transition transform hover:scale-105">Email Password Reset Link</button>
            </div>
            <div class="mt-4 text-end">
                <a href="{{ Route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 transition text-end">back to login page</a>
            </div>
        </form>
    </div>
</x-front>
