@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Choose Your Membership</h1>
            <p class="text-gray-600 mt-2">Select a tier that fits your climbing needs</p>
        </div>

        <!-- Messages -->
        @if ($message = Session::get('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                {{ $message }}
            </div>
        @endif

        <!-- Tier Cards -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            @foreach($tiers as $tier)
                <form action="{{ route('member.select-tier.post') }}" method="POST" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    @csrf

                    <div class="p-8">
                        <!-- Tier Header -->
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $tier->name }}</h2>
                            <div class="mt-4">
                                <span class="text-5xl font-bold text-blue-600">Rs. {{ number_format($tier->price) }}</span>
                                <span class="text-gray-600 ml-2">/month</span>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mb-8">
                            <h3 class="font-semibold text-gray-900 mb-4">Included Features:</h3>
                            <ul class="space-y-3">
                                @php
                                    $features = json_decode($tier->features, true);
                                    if (is_array($features)) {
                                        foreach ($features as $feature) {
                                            echo '<li class="flex items-start">
                                                <span class="text-green-500 mr-3">✓</span>
                                                <span class="text-gray-700">' . $feature . '</span>
                                            </li>';
                                        }
                                    }
                                @endphp
                            </ul>
                        </div>

                        <!-- Select Button -->
                        <div>
                            <input type="hidden" name="membership_tier_id" value="{{ $tier->id }}">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                                Select {{ $tier->name }}
                            </button>
                        </div>

                        <!-- Description -->
                        <p class="text-center text-sm text-gray-600 mt-4">
                            {{ $tier->description }}
                        </p>
                    </div>

                    <!-- Pricing Note -->
                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                        <p class="text-xs text-gray-600">
                            💡 Billed monthly. Cancel anytime.
                        </p>
                    </div>
                </form>
            @endforeach
        </div>

        <!-- Terms -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Before You Continue</h3>
            <div class="space-y-2 text-sm text-gray-700">
                <p>✓ Your membership will auto-renew each month</p>
                <p>✓ You can cancel anytime from your account settings</p>
                <p>✓ No hidden charges or long-term commitments</p>
                <p>✓ All prices are in Pakistani Rupees (PKR)</p>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('member.register') }}" class="text-gray-600 hover:text-gray-700">
                ← Back
            </a>
        </div>
    </div>
</div>
@endsection
