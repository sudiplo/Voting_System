<x-front>
    <div class="bg-[#efeff1] hover:bg-white p-20 rounded shadow-xl">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-5">
                <label for="email" :value="__('Email') " class="block mb-2.5 text-xl font-medium text-heading">Email</label>
                <input type="email" id="email" name="email" :value="old('email', $request->email)" class="bg-neutral-secondary-medium border border-default-medium text-heading text-xl rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required autofocus autocomplete="username" />
            </div>

            <div class="mt-5">
                <label for="password" :value="__('Password')" class="block mb-2.5 text-xl font-medium text-heading" >Password</label>
                <input type="password" id="password" class="block mt-1 w-full" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-5">
                <label for="password_confirmation" :value="__('Confirm Password')" class="block mb-2.5 text-xl font-medium text-heading">Confirm Password</label>
                <input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password"/>
            </div>
            <div class="p-4">
                <button class="bg-blue-500 text-white px-8 py-3 rounded shadow hover:bg-blue-600 transition flex items-center text-xl space-x-2"> Reset Password</button>
            </div>
        </form>
    </div>

</x-front>
