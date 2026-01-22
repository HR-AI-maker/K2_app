@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header with Greeting -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 3rem; font-weight: 900; color: #1E262A; margin: 0 0 0.75rem; line-height: 1.2;">Admin Dashboard</h1>
            <p style="color: #6C6C6C; margin: 0; font-size: 1.125rem; line-height: 1.6;">
                Welcome back, <span style="font-weight: 700; color: #3F23E5;">{{ auth()->user()->full_name }}</span>! 👋 Here's your platform overview.
            </p>
        </div>
        <div style="text-align: right; color: #94A3B8; font-size: 1rem; font-weight: 500;">
            <p style="margin: 0;">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>
</div>

<!-- KPI Cards Row - Premium Design -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
    <!-- Revenue This Month - Featured Card -->
    <div style="grid-column: span 2; background: linear-gradient(135deg, #3F23E5 0%, #5F4FEB 100%); color: white; overflow: hidden; position: relative; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 40px rgba(63, 35, 229, 0.3);">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p style="margin: 0 0 1rem; opacity: 0.95; font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Congratulations! 🎉</p>
                    <h2 style="margin: 0 0 1rem; font-size: 3rem; font-weight: 900; line-height: 1;">PKR {{ number_format($stats['revenueThisMonth'], 0) }}</h2>
                    <p style="margin: 0 0 1.5rem; opacity: 0.9; font-size: 1.25rem; line-height: 1.6;">Revenue this month</p>
                    <a href="#" style="display: inline-block; background: rgba(255,255,255,0.2); color: white; padding: 0.875rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-size: 1rem; font-weight: 700; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s ease;">
                        View Report →
                    </a>
                </div>
                <div style="font-size: 5rem; opacity: 0.2;">💰</div>
            </div>
        </div>
    </div>

    <!-- Total Members Card -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #3F23E5; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Members</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2.5rem; font-weight: 900; color: #1E262A;">{{ $stats['totalMembers'] }}</h3>
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; color: #10b981; font-weight: 600;">
                    <span>📈</span>
                    <span>+12.5% this month</span>
                </div>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(63, 35, 229, 0.1) 0%, rgba(63, 35, 229, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #3F23E5; font-size: 2.5rem; flex-shrink: 0;">👥</div>
        </div>
    </div>

    <!-- Active Members Card -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #10b981; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Active Members</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2.5rem; font-weight: 900; color: #1E262A;">{{ $stats['activeMembers'] }}</h3>
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; color: #10b981; font-weight: 600;">
                    <span>✓</span>
                    <span>+8.2% this month</span>
                </div>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 2.5rem; flex-shrink: 0;">✨</div>
        </div>
    </div>
</div>

<!-- Status Cards Row - Member Management Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
    <!-- Pending Verification -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #FF771E; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pending Verification</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2.5rem; font-weight: 900; color: #1E262A;">{{ $stats['pendingVerification'] }}</h3>
                <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1rem; color: #FF771E; text-decoration: none; font-weight: 700; transition: all 0.3s ease;">
                    Review <span>→</span>
                </a>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(255, 119, 30, 0.1) 0%, rgba(255, 119, 30, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #FF771E; font-size: 2.5rem; flex-shrink: 0;">⏳</div>
        </div>
    </div>

    <!-- Expired Members -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #ef4444; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Expired Members</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2.5rem; font-weight: 900; color: #1E262A;">{{ $stats['expiredMembers'] }}</h3>
                <a href="{{ route('admin.members.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1rem; color: #ef4444; text-decoration: none; font-weight: 700; transition: all 0.3s ease;">
                    View <span>→</span>
                </a>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #ef4444; font-size: 2.5rem; flex-shrink: 0;">⏰</div>
        </div>
    </div>

    <!-- Suspended Members -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #06b6d4; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Suspended Members</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2.5rem; font-weight: 900; color: #1E262A;">{{ $stats['suspendedMembers'] }}</h3>
                <a href="{{ route('admin.members.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1rem; color: #06b6d4; text-decoration: none; font-weight: 700; transition: all 0.3s ease;">
                    Review <span>→</span>
                </a>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #06b6d4; font-size: 2.5rem; flex-shrink: 0;">🔒</div>
        </div>
    </div>

    <!-- Monthly Revenue - Secondary Card -->
    <div style="background: white; border-radius: 1.5rem; border: 2px solid #E0E0E0; border-left: 5px solid #3F23E5; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="margin: 0 0 0.75rem; font-size: 1rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Monthly Revenue</p>
                <h3 style="margin: 0 0 0.75rem; font-size: 2rem; font-weight: 900; color: #1E262A;">PKR {{ number_format($stats['revenueThisMonth'], 0) }}</h3>
                <p style="margin: 0; font-size: 1rem; color: #10b981; font-weight: 600;">Last month: PKR 450,000</p>
            </div>
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(63, 35, 229, 0.1) 0%, rgba(63, 35, 229, 0.05) 100%); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: #3F23E5; font-size: 2.5rem; flex-shrink: 0;">💵</div>
        </div>
    </div>
</div>

<!-- Main Content Grid - Quick Actions & Status Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Actions Card -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Quick Actions</h3>
            <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Common tasks</p>
        </div>
        <div class="vuexy-card-body">
            <div class="space-y-3">
                <a href="{{ route('admin.members.index') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: linear-gradient(135deg, rgba(115,103,240,0.1) 0%, rgba(115,103,240,0.05) 100%); border: 1px solid rgba(115,103,240,0.2); border-radius: 0.5rem; text-decoration: none; color: var(--primary); font-weight: 500; transition: all 0.2s ease;">
                    <span style="font-size: 1.25rem;">👥</span>
                    <span>View All Members</span>
                    <span style="margin-left: auto; opacity: 0.5;">→</span>
                </a>
                <a href="{{ route('admin.events.create') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: linear-gradient(135deg, rgba(40,199,111,0.1) 0%, rgba(40,199,111,0.05) 100%); border: 1px solid rgba(40,199,111,0.2); border-radius: 0.5rem; text-decoration: none; color: var(--success); font-weight: 500; transition: all 0.2s ease;">
                    <span style="font-size: 1.25rem;">📅</span>
                    <span>Create New Event</span>
                    <span style="margin-left: auto; opacity: 0.5;">→</span>
                </a>
                <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: linear-gradient(135deg, rgba(255,159,67,0.1) 0%, rgba(255,159,67,0.05) 100%); border: 1px solid rgba(255,159,67,0.2); border-radius: 0.5rem; text-decoration: none; color: var(--warning); font-weight: 500; transition: all 0.2s ease;">
                    <span style="font-size: 1.25rem;">📄</span>
                    <span>Review Documents</span>
                    <span style="margin-left: auto; opacity: 0.5;">→</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: linear-gradient(135deg, rgba(0,207,232,0.1) 0%, rgba(0,207,232,0.05) 100%); border: 1px solid rgba(0,207,232,0.2); border-radius: 0.5rem; text-decoration: none; color: var(--info); font-weight: 500; transition: all 0.2s ease;">
                    <span style="font-size: 1.25rem;">🛒</span>
                    <span>Review Orders</span>
                    <span style="margin-left: auto; opacity: 0.5;">→</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Member Status Overview -->
    <div class="vuexy-card lg:col-span-2">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Member Status Overview</h3>
            <span class="vuexy-badge" style="background: rgba(115,103,240,0.1); color: var(--primary); border: 1px solid rgba(115,103,240,0.3);">This Month</span>
        </div>
        <div class="vuexy-card-body">
            <div class="space-y-5">
                <!-- Active Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary);">✓ Active Members</span>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--success);">{{ $stats['activeMembers'] }} / {{ $stats['totalMembers'] }}</span>
                    </div>
                    <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%); width: {{ $stats['totalMembers'] > 0 ? ($stats['activeMembers'] / $stats['totalMembers'] * 100) : 0 }}%; border-radius: 4px; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- Pending Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary);">⏳ Pending Verification</span>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--warning);">{{ $stats['pendingVerification'] }} / {{ $stats['totalMembers'] }}</span>
                    </div>
                    <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, var(--warning) 0%, var(--primary) 100%); width: {{ $stats['totalMembers'] > 0 ? ($stats['pendingVerification'] / $stats['totalMembers'] * 100) : 0 }}%; border-radius: 4px; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- Suspended Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary);">🔒 Suspended</span>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--danger);">{{ $stats['suspendedMembers'] }} / {{ $stats['totalMembers'] }}</span>
                    </div>
                    <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, var(--danger) 0%, var(--primary) 100%); width: {{ $stats['totalMembers'] > 0 ? ($stats['suspendedMembers'] / $stats['totalMembers'] * 100) : 0 }}%; border-radius: 4px; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- Expired Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary);">⏰ Expired</span>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">{{ $stats['expiredMembers'] }} / {{ $stats['totalMembers'] }}</span>
                    </div>
                    <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, #b9b9c3 0%, var(--primary) 100%); width: {{ $stats['totalMembers'] > 0 ? ($stats['expiredMembers'] / $stats['totalMembers'] * 100) : 0 }}%; border-radius: 4px; transition: width 0.3s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Section - Recently Verified & Registrations -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recently Verified Members -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <div>
                <h3 class="vuexy-card-title">Recently Verified 🎉</h3>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">New member verification</p>
            </div>
            <a href="{{ route('admin.members.index') }}" style="font-size: 0.875rem; color: var(--primary); text-decoration: none; transition: all 0.2s ease;">View All →</a>
        </div>
        <div class="vuexy-card-body" style="padding: 0;">
            @forelse($recentMembers as $member)
                <a href="{{ route('admin.members.show', $member) }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem 1.5rem; text-decoration: none; border-bottom: 1px solid var(--border-color); transition: all 0.2s ease;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(115,103,240,0.1) 0%, rgba(115,103,240,0.05) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-size: 0.9375rem; font-weight: 600; color: var(--text-primary);">{{ $member->full_name }}</p>
                        <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">{{ $member->email }}</p>
                    </div>
                    <span style="background: rgba(40,199,111,0.1); color: var(--success); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">✓ Verified</span>
                </a>
            @empty
                <div style="padding: 2rem; text-align: center;">
                    <p style="margin: 0; color: var(--text-muted); font-size: 0.9375rem;">
                        <span style="font-size: 2rem; display: block; margin-bottom: 0.5rem;">👤</span>
                        No recently verified members
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Event Registrations -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <div>
                <h3 class="vuexy-card-title">Event Registrations 📅</h3>
                <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Latest event sign-ups</p>
            </div>
            <a href="#" style="font-size: 0.875rem; color: var(--primary); text-decoration: none; transition: all 0.2s ease;">View All →</a>
        </div>
        <div class="vuexy-card-body" style="padding: 0;">
            @forelse($recentRegistrations as $registration)
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(40,199,111,0.1) 0%, rgba(40,199,111,0.05) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--success); flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-size: 0.9375rem; font-weight: 600; color: var(--text-primary);">{{ $registration->user->full_name }}</p>
                        <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">{{ $registration->event->title }}</p>
                    </div>
                    @if($registration->status === 'registered')
                        <span style="background: rgba(40,199,111,0.1); color: var(--success); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">✓ Registered</span>
                    @else
                        <span style="background: rgba(255,159,67,0.1); color: var(--warning); padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">{{ ucfirst($registration->status) }}</span>
                    @endif
                </div>
            @empty
                <div style="padding: 2rem; text-align: center;">
                    <p style="margin: 0; color: var(--text-muted); font-size: 0.9375rem;">
                        <span style="font-size: 2rem; display: block; margin-bottom: 0.5rem;">📋</span>
                        No recent registrations
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
