<x-top-layout>
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10 border border-gray-200">

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-700">
                🔐 Change Password
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Update your account password to keep your account secure.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                    Current Password
                </label>
                <div class="relative">
                    <input id="current_password" name="current_password" type="password" required autocomplete="current-password" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10" placeholder="Enter current password"/>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        🔑
                    </span>
                </div>
                <x-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    New Password
                </label>
                <div class="relative">
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10" placeholder="Create a strong password"/>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        🔒
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Must be at least 8 characters.
                </p>
                <x-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm New Password
                </label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10" placeholder="Re-enter new password"/>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        ✅
                    </span>
                </div>
                <x-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-sm text-green-600 font-medium">
                        ✔ Password updated successfully
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- Security Tips -->
    <div class="max-w-3xl mx-auto mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
        💡 <strong>Security Tip:</strong>
        Avoid using common passwords and never share your login details with anyone.
    </div>
</x-top-layout>
