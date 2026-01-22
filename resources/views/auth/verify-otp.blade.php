@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">✉️</div>
            <h1 class="text-2xl font-bold text-gray-900">Verify Your Email</h1>
            <p class="text-gray-600 mt-2">We sent a code to <strong>{{ $email }}</strong></p>
        </div>

        <!-- Messages -->
        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                {{ $message }}
            </div>
        @endif

        <!-- OTP Form -->
        <form action="{{ route('member.verify-otp.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- OTP Input -->
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Enter 6-digit Code</label>
                <input type="text" id="otp" name="otp" inputmode="numeric" maxlength="6"
                    class="mt-1 block w-full text-center text-2xl tracking-widest px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('otp') border-red-500 @enderror"
                    placeholder="000000"
                    required
                    pattern="[0-9]{6}">
                @error('otp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Verify Code
            </button>

            <!-- Resend OTP -->
            <div class="text-center pt-2">
                <p class="text-sm text-gray-600">
                    Didn't receive the code?
                    <button type="button" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Resend OTP
                    </button>
                </p>
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-xs text-blue-700">
                ℹ️ The code will expire in <strong>10 minutes</strong>. Check your spam folder if you don't see the email.
            </p>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-4">
            <a href="{{ route('member.register') }}" class="text-gray-600 hover:text-gray-700 text-sm">
                ← Back to Registration
            </a>
        </div>
    </div>
</div>

<script>
    // Auto-focus next input (optional enhancement)
    const otpInput = document.getElementById('otp');
    otpInput?.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
