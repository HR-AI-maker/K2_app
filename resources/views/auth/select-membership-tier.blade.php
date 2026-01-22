@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-900">Membership Plans</h1>
            <p class="text-xl text-gray-600 mt-3">Choose Your Adventure Level</p>
            <p class="text-gray-500 mt-2">Flexible membership options designed for every type of mountain enthusiast</p>
        </div>

        <!-- Messages -->
        @if ($message = Session::get('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                {{ $message }}
            </div>
        @endif

        <!-- Tier Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($tiers as $tier)
                @php
                    $isPopular = $tier->name === 'Premium';
                    $emoji = match($tier->name) {
                        'Basic' => '🏕️',
                        'Premium' => '⛰️',
                        'Elite' => '🏔️',
                        default => '🏔️'
                    };
                @endphp

                <form action="{{ route('member.select-tier.post') }}" method="POST" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 {{ $isPopular ? 'ring-2 ring-blue-500 transform scale-105' : '' }}">
                    @csrf

                    <!-- Popular Badge -->
                    @if($isPopular)
                        <div class="bg-blue-500 text-white text-center py-2 text-sm font-bold">
                            Most Popular
                        </div>
                    @endif

                    <div class="p-8">
                        <!-- Tier Header -->
                        <div class="text-center mb-8">
                            <div class="text-5xl mb-4">{{ $emoji }}</div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $tier->name }}</h2>
                            <p class="text-gray-600 mt-2 text-sm">{{ $tier->description }}</p>
                        </div>

                        <!-- Price -->
                        <div class="text-center mb-8">
                            <span class="text-5xl font-bold text-gray-900">PKR {{ number_format($tier->price) }}</span>
                            <span class="text-gray-600 ml-2">/month</span>
                        </div>

                        <!-- Features -->
                        <div class="mb-8">
                            <ul class="space-y-4">
                                @if(is_array($tier->features))
                                    @foreach($tier->features as $feature)
                                        <li class="flex items-start">
                                            <span class="text-green-500 mr-3 text-lg">✓</span>
                                            <span class="text-gray-700 font-medium">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <!-- Select Button -->
                        <div>
                            <input type="hidden" name="membership_tier_id" value="{{ $tier->id }}">
                            <button type="submit" class="w-full {{ $isPopular ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-700 hover:bg-gray-800' }} text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                                {{ $tier->name === 'Basic' ? 'Get Started' : ($tier->name === 'Premium' ? 'Get Premium' : 'Go Elite') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>

        <!-- Back Link -->
        <div class="text-center mt-12">
            <a href="{{ route('member.register') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                ← Back to Registration
            </a>
        </div>
    </div>
</div>
@endsection
