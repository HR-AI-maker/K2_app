@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Payment Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Complete Payment</h1>
                <p class="text-gray-600 mt-2">{{ $tier['name'] }} Membership</p>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700">{{ $tier['name'] }} (1 month)</span>
                    <span class="font-semibold">Rs. {{ number_format($tier['price']) }}</span>
                </div>
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-blue-600">Rs. {{ number_format($tier['price']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($message = Session::get('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Payment Form -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('member.process-payment') }}" method="POST" id="payment-form">
                @csrf

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">💳 Card Details</h2>

                    <!-- Card Number -->
                    <div class="mb-4">
                        <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                        <input type="text" id="card_number" name="card_number" inputmode="numeric" maxlength="16"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('card_number') border-red-500 @enderror"
                            placeholder="4111111111111111"
                            required
                            value="{{ old('card_number') }}">
                        @error('card_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Card Holder -->
                    <div class="mb-4">
                        <label for="card_holder" class="block text-sm font-medium text-gray-700">Card Holder Name</label>
                        <input type="text" id="card_holder" name="card_holder"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('card_holder') border-red-500 @enderror"
                            placeholder="Your Name"
                            required
                            value="{{ old('card_holder') }}">
                        @error('card_holder')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry Date and CVV -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="text" id="expiry_date" name="expiry_date" inputmode="numeric" placeholder="MM/YY" maxlength="5"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('expiry_date') border-red-500 @enderror"
                                required
                                value="{{ old('expiry_date') }}">
                            @error('expiry_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                            <input type="text" id="cvv" name="cvv" inputmode="numeric" maxlength="3" placeholder="123"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('cvv') border-red-500 @enderror"
                                required
                                value="{{ old('cvv') }}">
                            @error('cvv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Secure Payment Note -->
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-xs text-green-700">
                        🔒 <strong>Secure Payment</strong> - Your card information is encrypted and secure.
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Pay Rs. {{ number_format($tier['price']) }}
                </button>

                <!-- Cancel Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('member.select-tier') }}" class="text-gray-600 hover:text-gray-700 text-sm">
                        ← Back to Tier Selection
                    </a>
                </div>
            </form>
        </div>

        <!-- Test Card Numbers -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">🧪 Test Card Numbers</h3>
            <div class="space-y-2 text-xs text-gray-700">
                <p>💳 <strong>Visa:</strong> 4111111111111111</p>
                <p>💳 <strong>Mastercard:</strong> 5555555555554444</p>
                <p>📅 <strong>Any future date</strong> (e.g., 12/25)</p>
                <p>🔐 <strong>Any 3-digit CVV</strong> (except 000 or 999)</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Format card number
    document.getElementById('card_number')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });

    // Format expiry date
    document.getElementById('expiry_date')?.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        this.value = value;
    });

    // Format CVV
    document.getElementById('cvv')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 3);
    });
</script>
@endsection
