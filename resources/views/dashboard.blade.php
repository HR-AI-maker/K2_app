@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Welcome back, {{ $user->first_name }}! 👋</h1>
            <p class="text-gray-600 mt-2">
                @if ($membershipExpired)
                    Your membership has expired. <a href="{{ route('profile.membership') }}" class="text-blue-600 hover:underline">Renew now</a>
                @elseif ($daysUntilExpiry !== null && $daysUntilExpiry <= 30)
                    Your membership expires in {{ $daysUntilExpiry }} days
                @else
                    Your membership is active and in good standing
                @endif
            </p>
        </div>

        <!-- Profile Completion Banner -->
        <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Complete Your Profile</h2>
                    <p class="text-blue-100">{{ $profileCompleteness }}% complete - You're doing great!</p>
                </div>
                <div class="text-5xl font-bold opacity-20">{{ $profileCompleteness }}%</div>
            </div>
            <div class="mt-4 bg-blue-400 rounded-full h-3 overflow-hidden">
                <div class="bg-white h-full rounded-full" style="width: {{ $profileCompleteness }}%"></div>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50">
                    Edit Profile
                </a>
                <a href="{{ route('profile.documents') }}" class="px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-800">
                    Upload Documents
                </a>
                <a href="{{ route('profile.medical') }}" class="px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-800">
                    Medical Info
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left Column) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['events_registered'] }}</p>
                        <p class="text-sm text-gray-600">Events Registered</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $stats['expeditions_applied'] }}</p>
                        <p class="text-sm text-gray-600">Expeditions Applied</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['community_posts'] }}</p>
                        <p class="text-sm text-gray-600">Posts Created</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['badges_earned'] }}</p>
                        <p class="text-sm text-gray-600">Badges Earned</p>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="card">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">📅 Upcoming Events</h2>
                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:underline text-sm">View All</a>
                    </div>
                    @if ($upcomingEvents->count() > 0)
                        <div class="space-y-3">
                            @foreach ($upcomingEvents as $reg)
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <p class="font-semibold">{{ $reg->event->title }}</p>
                                    <p class="text-sm text-gray-600">
                                        📍 {{ $reg->event->location }} • 📅 {{ $reg->event->start_date->format('M d, Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-6">No upcoming events. <a href="{{ route('events.index') }}" class="text-blue-600 hover:underline">Browse events</a></p>
                    @endif
                </div>

                <!-- Expedition Applications -->
                <div class="card">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">🏔️ Expedition Applications</h2>
                        <a href="{{ route('expeditions.index') }}" class="text-blue-600 hover:underline text-sm">Browse</a>
                    </div>
                    @if ($expeditionApps->count() > 0)
                        <div class="space-y-3">
                            @foreach ($expeditionApps->slice(0, 3) as $app)
                                <div class="border rounded-lg p-3 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">{{ $app->expedition->title }}</p>
                                            <p class="text-sm text-gray-600">Applied {{ $app->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="badge
                                            @if ($app->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif ($app->status === 'approved') bg-green-100 text-green-800
                                            @elseif ($app->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif
                                        ">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-6">No applications yet. <a href="{{ route('expeditions.index') }}" class="text-blue-600 hover:underline">Apply for expeditions</a></p>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">📊 Recent Activity</h2>
                    @if (count($activities) > 0)
                        <div class="space-y-4">
                            @foreach ($activities as $activity)
                                <div class="flex gap-4 pb-4 border-b last:border-b-0">
                                    <div class="text-2xl">{{ $activity['icon'] }}</div>
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $activity['title'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity['date']->diffForHumans() }}</p>
                                    </div>
                                    <span class="badge text-xs {{ $activity['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($activity['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($activity['status']) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-6">No recent activity</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar (Right Column) -->
            <div class="space-y-8">
                <!-- Quick Actions -->
                <div class="card">
                    <h3 class="text-xl font-bold mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('events.index') }}" class="block p-3 rounded-lg border hover:bg-blue-50 hover:border-blue-300 transition">
                            🎫 Browse Events
                        </a>
                        <a href="{{ route('expeditions.index') }}" class="block p-3 rounded-lg border hover:bg-green-50 hover:border-green-300 transition">
                            ⛰️ Browse Expeditions
                        </a>
                        <a href="{{ route('profile.documents') }}" class="block p-3 rounded-lg border hover:bg-purple-50 hover:border-purple-300 transition">
                            📄 Upload Documents
                        </a>
                        <a href="{{ route('profile.membership') }}" class="block p-3 rounded-lg border hover:bg-yellow-50 hover:border-yellow-300 transition">
                            🏷️ Membership Status
                        </a>
                    </div>
                </div>

                <!-- Membership Card -->
                <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
                    <h3 class="text-lg font-bold mb-3">💳 Membership</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-600">Tier</p>
                            <p class="text-lg font-bold capitalize">{{ $user->membership_tier ?? 'None' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Status</p>
                            <p class="text-lg font-bold capitalize">
                                @if ($membershipExpired)
                                    <span class="text-red-600">Expired</span>
                                @else
                                    <span class="text-green-600">Active</span>
                                @endif
                            </p>
                        </div>
                        @if ($latestMembership)
                            <div>
                                <p class="text-xs text-gray-600">Expires</p>
                                <p class="text-sm font-semibold">{{ $latestMembership->expires_at->format('M d, Y') }}</p>
                            </div>
                        @endif
                        <a href="{{ route('profile.membership') }}" class="block mt-4 text-center p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Documents Status -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-3">📋 Documents</h3>
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-green-600">{{ $stats['documents_verified'] }}/{{ $stats['documents_total'] }}</p>
                        <p class="text-xs text-gray-600">Verified Documents</p>
                    </div>
                    @if ($stats['documents_total'] < 4)
                        <p class="text-sm text-yellow-700 bg-yellow-50 p-3 rounded mb-3">
                            ⚠️ Please upload all required documents
                        </p>
                    @endif
                    <a href="{{ route('profile.documents') }}" class="w-full text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                        Manage Documents
                    </a>
                </div>

                <!-- Badges -->
                @if ($stats['badges_earned'] > 0)
                    <div class="card">
                        <h3 class="text-lg font-bold mb-3">🏆 Badges</h3>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($user->badges->take(6) as $badge)
                                <div class="text-center p-2 rounded-lg bg-yellow-50">
                                    <p class="text-2xl">🏅</p>
                                    <p class="text-xs text-gray-700 truncate">{{ $badge->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('profile.badges') }}" class="mt-3 text-sm text-blue-600 hover:underline">View all badges →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
