<x-top-layout>
    <h2>Enter OTP to Cast Vote</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <label>Enter 6 Digit OTP:</label>
        <input type="text" name="otp" required>

        <button type="submit">Verify OTP</button>
    </form>

</x-top-layout>
