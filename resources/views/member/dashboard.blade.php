@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="mb-6" style="padding: 1.5rem; background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #5e5873; margin: 0 0 0.25rem;">Welcome, {{ $user->first_name }}! 👋</h1>
    <p style="color: #b9b9c3; margin: 0;">Access all Alpine features and explore the climbing community</p>
</div>

<!-- Stat Cards Row -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <!-- Membership Status -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Membership</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ ucfirst($user->membership_tier) }}</h3>
                @if($stats['active_membership'])
                    <span style="display: inline-block; font-size: 0.75rem; color: #28c76f; font-weight: 500; background: rgba(40,199,111,0.12); padding: 0.25rem 0.625rem; border-radius: 0.25rem;">
                        ✓ Active until {{ $stats['membership_expires_at']->format('M d, Y') }}
                    </span>
                @else
                    <span style="display: inline-block; font-size: 0.75rem; color: #ea5455; font-weight: 500; background: rgba(234,84,85,0.12); padding: 0.25rem 0.625rem; border-radius: 0.25rem;">
                        ⚠️ Expired
                    </span>
                @endif
            </div>
            <div style="width: 48px; height: 48px; background: rgba(115,103,240,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                🎫
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Orders</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['total_orders'] }}</h3>
                <a href="{{ route('orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; font-weight: 600; color: #7367f0; text-decoration: none;">
                    View Orders →
                </a>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(40,199,111,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                📦
            </div>
        </div>
    </div>

    <!-- Cart Items -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.875rem; color: #b9b9c3; margin: 0;">Cart Items</p>
                <h3 style="font-size: 1.75rem; font-weight: 600; color: #5e5873; margin: 0.5rem 0;">{{ $stats['total_cart_items'] }}</h3>
                <a href="{{ route('cart.index') }}" style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; font-weight: 600; color: #7367f0; text-decoration: none;">
                    View Cart →
                </a>
            </div>
            <div style="width: 48px; height: 48px; background: rgba(255,159,67,0.12); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                🛒
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Features -->
<div class="mb-6">
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #5e5873; margin: 0;">Quick Access</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Marketplace -->
        <a href="{{ route('marketplace.index') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🛒</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">Marketplace</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Browse and buy climbing gear, equipment, and services</p>
        </a>

        <!-- Events -->
        <a href="{{ route('events.index') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🎯</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">Events</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Discover climbing events, workshops, and training sessions</p>
        </a>

        <!-- Expeditions -->
        <a href="{{ route('expeditions.index') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🗻</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">Expeditions</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Join guided climbing expeditions and mountain adventures</p>
        </a>

        <!-- Community -->
        <a href="{{ route('community.index') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">👥</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">Community</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Connect with other climbers and share experiences</p>
        </a>

        <!-- Vendors -->
        <a href="{{ route('vendors.index') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🏢</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">Vendors</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Discover verified climbing service providers and shops</p>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; padding: 1.5rem; text-decoration: none; display: block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 32px 0 rgba(34,41,47,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px 0 rgba(34,41,47,0.1)';">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">👤</div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0 0 0.5rem;">My Profile</h3>
            <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0;">Manage your profile, documents, and settings</p>
        </a>
    </div>
</div>

<!-- Membership Features Section -->
<div style="background: white; border-radius: 0.5rem; box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1); border: 1px solid #ebe9f1; margin-bottom: 1.5rem; overflow: hidden;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #ebe9f1;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #5e5873; margin: 0;">Your {{ ucfirst($user->membership_tier) }} Membership Includes</h2>
    </div>
    <div style="padding: 1.5rem;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Community Access</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Marketplace Access</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">GPS Tracking</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Offline Maps</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">SOS System</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Event Discount</span>
            </div>
            @if(strtolower($user->membership_tier) === 'premium')
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Priority Support</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="color: #28c76f; font-weight: 600;">✓</span>
                <span style="color: #5e5873; font-weight: 500; font-size: 0.875rem;">Exclusive Content</span>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Call-to-Action -->
@if(!$stats['active_membership'])
<div style="background: rgba(255,159,67,0.12); border: 1px solid rgba(255,159,67,0.2); border-radius: 0.5rem; padding: 1.5rem; display: flex; gap: 1rem;">
    <div style="color: #ff9f43; font-size: 1.5rem;">⚠️</div>
    <div>
        <strong style="color: #ff9f43; font-size: 0.9375rem;">Your Membership Has Expired</strong>
        <p style="color: #b9b9c3; font-size: 0.875rem; margin: 0.5rem 0 0;">Renew your membership to continue accessing all Alpine features and stay connected with the community.</p>
        <a href="{{ route('profile.membership') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(118deg, #7367f0, #9e95f5); color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; margin-top: 0.75rem; text-decoration: none;">
            ↻ Renew Membership
        </a>
    </div>
</div>
@endif
@endsection
