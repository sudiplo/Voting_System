<x-front>
    <div class="bg-white shadow-2xl rounded-lg max-w-4xl mx-auto p-8 transform transition-all duration-300 ease-in-out hover:scale-105">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Create Your Account</h2>
        <p class="text-center text-gray-600 mb-8">Fill out the form to register and join us.</p>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required />
                </div>

                <div>
                    <label for="citizenNumber" class="block text-sm font-medium text-gray-700">Citizenship Number</label>
                    <input type="number" id="number" name="number" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="" required />
                </div>

                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700">Date of birth</label>
                    <input type="date" id="dob" name="dob" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required />
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="name@flowbite.com" required />
                    <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('email')" />
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required />
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                    <input type="file" id="photo" name="photo" class="w-full border border-gray-300 rounded-md px-4 py-3 mt-2 bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 mt-2 bg-neutral-100 border border-gray-300 rounded-md text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required />
                    <x-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('password')" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 transition">Already have an account? Login</a>
                <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-700 focus:outline-none transition transform hover:scale-105">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-front>
