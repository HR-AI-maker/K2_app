@extends('layouts.member')

@section('content')
<!-- Page Header - Hero Section -->
<div style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 2.75rem; font-weight: 900; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Welcome back, <span style="background: linear-gradient(135deg, #3F23E5 0%, #FF771E 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $user->first_name }}</span>! 👋</h1>
            <p style="font-size: 1.25rem; color: #6C6C6C; margin: 0; line-height: 1.6;">Ready for your next climbing adventure?</p>
        </div>
        <div style="text-align: right; color: #94A3B8; font-size: 1rem; font-weight: 500;">
            <p style="margin: 0;">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>
</div>

<!-- KPI Cards - Membership & Activity -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
    <!-- Membership Card - Featured -->
    <div style="background: linear-gradient(135deg, #3F23E5 0%, #5F4FEB 100%); border-radius: 1.5rem; border-left: 5px solid #FF771E; padding: 2rem; color: white; box-shadow: 0 10px 30px rgba(63, 35, 229, 0.2);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="font-size: 1rem; color: rgba(255, 255, 255, 0.8); font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Your Membership</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: white; margin: 0 0 1rem; line-height: 1.1;">{{ ucfirst($user->membership_tier) }} 🎫</h3>
                @if($stats['active_membership'])
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #FFD700; font-weight: 700;">
                        <span>✓ Active until {{ $stats['membership_expires_at']->format('M d, Y') }}</span>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; color: #FFB84D; font-weight: 700;">
                        <span>⚠️ Membership Expired</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #2563eb; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="flex: 1;">
                <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Orders</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['total_orders'] }} 📦</h3>
                <a href="{{ route('orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb; text-decoration: none; transition: all 0.3s ease;">
                    View All Orders →
                </a>
            </div>
        </div>
    </div>

    <!-- Cart Items Card -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #FF771E; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="flex: 1;">
                <p style="font-size: 1rem; color: #94A3B8; font-weight: 600; margin: 0 0 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Items in Cart</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: #1E262A; margin: 0 0 1rem;">{{ $stats['total_cart_items'] }} 🛒</h3>
                <a href="{{ route('cart.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #FF771E; text-decoration: none; transition: all 0.3s ease;">
                    Go to Cart →
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access - Modern Card Grid -->
<div style="margin-bottom: 2.5rem;">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 2.25rem; font-weight: 900; color: #1E262A; margin: 0; line-height: 1.2;">Quick Access 🚀</h2>
        <p style="color: #6C6C6C; margin: 0.75rem 0 0; font-size: 1.125rem; line-height: 1.6;">Jump into your climbing adventure</p>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        <!-- Marketplace Card -->
        <a href="{{ route('marketplace.index') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(37, 99, 235, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">🛒</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Marketplace</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Browse & buy climbing gear</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Explore →</span>
        </a>

        <!-- Events Card -->
        <a href="{{ route('events.index') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">📅</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Events</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Climbing events & workshops</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Find Events →</span>
        </a>

        <!-- Expeditions Card -->
        <a href="{{ route('expeditions.index') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(249, 115, 22, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">⛰️</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Expeditions</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Join guided adventures</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Browse →</span>
        </a>

        <!-- Community Card -->
        <a href="{{ route('community.index') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(139, 92, 246, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">👥</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Community</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Connect worldwide</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Join →</span>
        </a>

        <!-- Vendors Card -->
        <a href="{{ route('vendors.index') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">🏪</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Vendors</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Service providers</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Browse →</span>
        </a>

        <!-- Profile Card -->
        <a href="{{ route('profile.edit') }}" style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; padding: 2rem; text-decoration: none; display: block; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow = '0 15px 40px rgba(0,0,0,0.1)'; this.style.transform = 'translateY(-5px)';"
            onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
            <div style="font-size: 2.75rem; margin-bottom: 1rem; display: inline-block; background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%); padding: 1rem 1.25rem; border-radius: 0.75rem;">⚙️</div>
            <h3 style="font-size: 1.375rem; font-weight: 800; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">My Profile</h3>
            <p style="color: #6C6C6C; font-size: 1rem; margin: 0 0 1.25rem; line-height: 1.5;">Account & preferences</p>
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 700; color: #2563eb;">Edit →</span>
        </a>
    </div>
</div>

<!-- Membership Features Section -->
<div class="member-card" style="margin-bottom: 2rem; padding: 2rem;">
    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0 0 1.5rem;">Your {{ ucfirst($user->membership_tier) }} Membership Includes ✨</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Community Access</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Marketplace Access</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">GPS Tracking</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Offline Maps</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">SOS System</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Event Discount</span>
        </div>
        @if(strtolower($user->membership_tier) === 'premium')
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Priority Support</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="color: var(--success); font-weight: 700; font-size: 1.25rem;">✓</span>
            <span style="color: var(--text-primary); font-weight: 500; font-size: 0.875rem;">Exclusive Content</span>
        </div>
        @endif
    </div>
</div>

<!-- Call-to-Action - Renewal Banner -->
@if(!$stats['active_membership'])
<div class="member-card" style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(249, 115, 22, 0.05) 100%); border-left: 5px solid var(--warning); padding: 2rem; display: flex; gap: 1.5rem; align-items: flex-start;">
    <div style="font-size: 2rem; flex-shrink: 0;">⏰</div>
    <div style="flex: 1;">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--warning); margin: 0 0 0.5rem;">Membership Has Expired</h3>
        <p style="color: var(--text-secondary); font-size: 0.9375rem; margin: 0 0 1rem;">Renew your membership to continue accessing all Alpine features, connect with the community, and explore exclusive climbing opportunities.</p>
        <a href="{{ route('profile.membership') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.2s ease;">
            ↻ Renew Membership
        </a>
    </div>
</div>
@endif
@endsection
