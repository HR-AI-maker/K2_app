@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome, {{ $user->first_name }}! 👋</h1>
        <p class="text-gray-600">Access all Alpine features and explore the climbing community</p>
    </div>

    <!-- Membership Status Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Membership Status -->
            <div class="border-l-4 border-blue-600 pl-4">
                <p class="text-sm text-gray-600 mb-1">Membership Status</p>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ ucfirst($user->membership_tier) }}</p>
                <p class="text-xs text-gray-600">
                    @if($stats['active_membership'])
                        ✓ Active until {{ $stats['membership_expires_at']->format('M d, Y') }}
                    @else
                        ⚠️ Membership ended
                    @endif
                </p>
            </div>

            <!-- Orders -->
            <div class="border-l-4 border-green-600 pl-4">
                <p class="text-sm text-gray-600 mb-1">Your Orders</p>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_orders'] }}</p>
                <a href="{{ route('orders.index') }}" class="text-xs text-green-600 hover:text-green-700 font-semibold">View Orders →</a>
            </div>

            <!-- Cart -->
            <div class="border-l-4 border-purple-600 pl-4">
                <p class="text-sm text-gray-600 mb-1">Shopping Cart</p>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_cart_items'] }}</p>
                <a href="{{ route('cart.index') }}" class="text-xs text-purple-600 hover:text-purple-700 font-semibold">View Cart →</a>
            </div>
        </div>
    </div>

    <!-- Quick Access Features -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Access</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Marketplace -->
            <a href="{{ route('marketplace.index') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">🛒</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Marketplace</h3>
                <p class="text-gray-600 text-sm mb-4">Browse and buy climbing gear, equipment, and services</p>
                <span class="text-blue-600 font-semibold text-sm">Explore →</span>
            </a>

            <!-- Events -->
            <a href="{{ route('events.index') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Events</h3>
                <p class="text-gray-600 text-sm mb-4">Discover climbing events, workshops, and training sessions</p>
                <span class="text-blue-600 font-semibold text-sm">Browse →</span>
            </a>

            <!-- Expeditions -->
            <a href="{{ route('expeditions.index') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">🗻</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Expeditions</h3>
                <p class="text-gray-600 text-sm mb-4">Join guided climbing expeditions and mountain adventures</p>
                <span class="text-blue-600 font-semibold text-sm">View →</span>
            </a>

            <!-- Community -->
            <a href="{{ route('community.index') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">👥</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Community</h3>
                <p class="text-gray-600 text-sm mb-4">Connect with other climbers and share experiences</p>
                <span class="text-blue-600 font-semibold text-sm">Connect →</span>
            </a>

            <!-- Vendors -->
            <a href="{{ route('vendors.index') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">🏢</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Vendors</h3>
                <p class="text-gray-600 text-sm mb-4">Discover verified climbing service providers and shops</p>
                <span class="text-blue-600 font-semibold text-sm">Explore →</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('profile.edit') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform p-6">
                <div class="text-5xl mb-4">👤</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">My Profile</h3>
                <p class="text-gray-600 text-sm mb-4">Manage your profile, documents, and settings</p>
                <span class="text-blue-600 font-semibold text-sm">Edit →</span>
            </a>
        </div>
    </div>

    <!-- Membership Features -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Your {{ ucfirst($user->membership_tier) }} Membership Includes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Community Access</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Marketplace Access</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">GPS Tracking</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Offline Maps</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">SOS System</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Event Discount</span>
            </div>
            @if(strtolower($user->membership_tier) === 'premium')
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Priority Support</span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl mr-3">✓</span>
                <span class="text-gray-700">Exclusive Content</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Call-to-Action -->
    @if(!$stats['active_membership'])
    <div class="bg-orange-50 border-l-4 border-orange-500 p-6 rounded-lg">
        <h3 class="text-lg font-bold text-orange-900 mb-2">Your Membership Has Expired</h3>
        <p class="text-orange-800 mb-4">Renew your membership to continue accessing all Alpine features and stay connected with the community.</p>
        <a href="{{ route('profile.membership') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg">
            Renew Membership
        </a>
    </div>
    @endif
</div>
@endsection
