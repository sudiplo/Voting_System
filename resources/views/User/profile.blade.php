{{-- <x-top-layout>

    <div class="max-w-3xl mx-auto mt-10">

        <!-- Card -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-6 text-white">
                <h2 class="text-2xl font-bold">Profile Settings</h2>
                <p class="text-sm text-blue-100 mt-1">
                    Manage your account information and email address.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('profile.update') }}" class="px-8 py-8 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>

                    <div class="relative">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            autocomplete="username"
                            value="{{ Auth::user()->email }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-11"
                        >
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            📧
                        </span>
                    </div>

                    <x-error class="mt-2" :messages="$errors->get('email')" />

                    <!-- Email Verification Notice -->
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-4 rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-sm text-yellow-800">
                            ⚠️ <strong>Email not verified.</strong>
                            <p class="mt-1">
                                Please verify your email address to secure your account.
                            </p>

                            <button
                                form="send-verification"
                                class="mt-2 inline-block text-sm font-medium text-blue-600 hover:text-blue-700 underline"
                            >
                                Re-send verification email
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-green-600 font-medium">
                                    ✔ A new verification link has been sent.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition"
                    >
                        Save Changes
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2500)"
                            class="text-green-600 text-sm font-medium"
                        >
                            ✔ Profile updated successfully
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
            ℹ️ <strong>Tip:</strong>
            Make sure your email is active — it’s used for voting notifications and security alerts.
        </div>

    </div>
</x-top-layout> --}}
<x-top-layout>
    <div class="max-w-5xl mx-auto mt-8 sm:mt-12 px-4 sm:px-0">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- LEFT: Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6 text-center">

                    <!-- Avatar -->
                    <div class="flex justify-center">
                        <img
                            src="{{ Auth::user()->photo }}"
                            alt="Profile photo"
                            class="w-28 h-28 rounded-full object-cover border-4 border-blue-600"
                        >
                    </div>

                    <!-- Name -->
                    <h2 class="mt-4 text-xl font-bold text-gray-800">
                        {{ Auth::user()->name }}
                    </h2>

                    <!-- Email -->
                    <p class="text-sm text-gray-500 break-all">
                        {{ Auth::user()->email }}
                    </p>

                    <!-- Status -->
                    <div class="mt-4">
                        @if (Auth::user()->hasVerifiedEmail())
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                ✔ Verified Account
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                ⚠ Email Not Verified
                            </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 space-y-3">
                        <a
                            href="{{ route('user.profile.edit') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-lg transition"
                        >
                            Edit Profile
                        </a>

                        <a
                            href="{{ route('user.profile.edit') }}"
                            class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-lg transition"
                        >
                            Change Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Profile Details -->
            <div class="lg:col-span-3">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg">

                    <!-- Header -->
                    <div class="border-b px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Profile Information
                        </h3>
                        <p class="text-sm text-gray-500">
                            Overview of your account details.
                        </p>
                    </div>

                    <!-- Details -->
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Full Name
                            </p>
                            <p class="text-sm font-medium text-gray-800 mt-1">
                                {{ Auth::user()->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Email Address
                            </p>
                            <p class="text-sm font-medium text-gray-800 mt-1 break-all">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Account Created
                            </p>
                            <p class="text-sm font-medium text-gray-800 mt-1">
                                {{ Auth::user()->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Last Updated
                            </p>
                            <p class="text-sm font-medium text-gray-800 mt-1">
                                {{ Auth::user()->updated_at->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Role
                            </p>
                            <p class="text-sm font-medium text-gray-800 mt-1">
                                {{ Auth::user()->role ?? 'Voter' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">
                                Account Status
                            </p>
                            <p class="text-sm font-medium text-green-600 mt-1">
                                Active
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Note -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
                    🔐 <strong>Security Notice:</strong>
                    Your personal information is protected and never shared with other users.
                </div>
            </div>

        </div>
    </div>
</x-top-layout>
