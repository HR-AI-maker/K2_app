@extends('layouts.app')

@section('title', 'Membership')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">Membership Status</h1>
            <p class="text-gray-600 mt-2">View and manage your membership</p>
        </div>

        <!-- Current Status Card -->
        <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <p class="text-sm text-blue-100 mb-1">Current Tier</p>
                    <p class="text-3xl font-bold capitalize">{{ $user->membership_tier ?? 'None' }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-100 mb-1">Status</p>
                    <p class="text-3xl font-bold">
                        @if ($user->membership_status === 'active')
                            ✓ Active
                        @elseif ($user->membership_status === 'expired')
                            ⏰ Expired
                        @elseif ($user->membership_status === 'suspended')
                            ⛔ Suspended
                        @else
                            ⏳ Pending
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-blue-100 mb-1">Verified</p>
                    <p class="text-3xl font-bold">
                        @if ($user->isVerified())
                            ✓ Yes
                        @else
                            ✗ No
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Membership History -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-6">📜 Membership History</h2>

            @if ($membershipHistory->count() > 0)
                <div class="space-y-4">
                    @foreach ($membershipHistory as $history)
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-bold capitalize">{{ $history->membership_tier }} Membership</p>
                                    <p class="text-sm text-gray-600">
                                        Started {{ $history->started_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="badge
                                    @if ($history->status === 'active') bg-green-100 text-green-800
                                    @elseif ($history->status === 'expired') bg-red-100 text-red-800
                                    @elseif ($history->status === 'suspended') bg-orange-100 text-orange-800
                                    @else bg-yellow-100 text-yellow-800 @endif
                                ">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t">
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Started</p>
                                    <p class="font-semibold">{{ $history->started_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Expires</p>
                                    <p class="font-semibold">{{ $history->expires_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Duration</p>
                                    <p class="font-semibold">{{ $history->started_at->diffInDays($history->expires_at) }} days</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No membership history</p>
            @endif
        </div>

        <!-- Membership Benefits -->
        <div class="card">
            <h2 class="text-2xl font-bold mb-6">💳 Membership Benefits</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Standard Benefits -->
                <div class="border rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4 text-blue-600">Standard Tier</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Event registration discounts</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Community forum access</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Safety alerts and newsletters</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Membership card</span>
                        </li>
                    </ul>
                </div>

                <!-- Premium Benefits -->
                <div class="border border-blue-300 rounded-lg p-6 bg-blue-50">
                    <h3 class="font-bold text-lg mb-4 text-blue-600">Premium Tier</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>All Standard benefits</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Priority event registration</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Exclusive expeditions</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Training discounts (20%)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <span>Gear rental discounts</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Lifetime Benefits -->
            <div class="border border-yellow-300 rounded-lg p-6 bg-yellow-50 mt-6">
                <h3 class="font-bold text-lg mb-4 text-yellow-900">🏆 Lifetime Tier</h3>
                <p class="text-sm text-yellow-900 mb-4">All Premium benefits plus:</p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 mt-1">✓</span>
                        <span>Unlimited event access</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 mt-1">✓</span>
                        <span>Free guide services (2x per year)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 mt-1">✓</span>
                        <span>VIP membership card</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-600 mt-1">✓</span>
                        <span>Listed as founding member</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('events.index') }}" class="card text-center hover:shadow-lg transition">
                <p class="text-3xl mb-2">🎫</p>
                <p class="font-semibold">Browse Events</p>
                <p class="text-sm text-gray-600">See member-exclusive events</p>
            </a>
            <a href="{{ route('profile.edit') }}" class="card text-center hover:shadow-lg transition">
                <p class="text-3xl mb-2">✏️</p>
                <p class="font-semibold">Edit Profile</p>
                <p class="text-sm text-gray-600">Update your information</p>
            </a>
        </div>
    </div>
</div>
@endsection
