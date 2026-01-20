@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Admin Dashboard</h1>
    <p class="text-gray-600 mt-2">Welcome, {{ auth()->user()->full_name }}</p>
</div>

<!-- System Health Overview -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
        <p class="text-gray-600 text-sm font-semibold">Total Members</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['totalMembers'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
        <p class="text-gray-600 text-sm font-semibold">Active Members</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['activeMembers'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
        <p class="text-gray-600 text-sm font-semibold">Pending Verification</p>
        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pendingVerification'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
        <p class="text-gray-600 text-sm font-semibold">Expired</p>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['expiredMembers'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
        <p class="text-gray-600 text-sm font-semibold">Revenue This Month</p>
        <p class="text-3xl font-bold text-purple-600 mt-2">PKR {{ number_format($stats['revenueThisMonth'], 0) }}</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.members.index') }}" class="p-4 border rounded-lg hover:bg-blue-50 text-center transition">
                <p class="font-semibold text-blue-600">👥 Manage Members</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-green-50 text-center transition">
                <p class="font-semibold text-green-600">📅 Create Event</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-purple-50 text-center transition">
                <p class="font-semibold text-purple-600">📊 View Reports</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-red-50 text-center transition">
                <p class="font-semibold text-red-600">🚨 Safety Records</p>
            </a>
        </div>
    </div>

    <!-- Member Status Overview -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Member Status Overview</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Active</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['totalMembers'] > 0 ? ($stats['activeMembers'] / $stats['totalMembers'] * 100) : 0 }}%"></div>
                    </div>
                    <span class="font-bold">{{ $stats['activeMembers'] }}</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Suspended</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $stats['totalMembers'] > 0 ? ($stats['suspendedMembers'] / $stats['totalMembers'] * 100) : 0 }}%"></div>
                    </div>
                    <span class="font-bold">{{ $stats['suspendedMembers'] }}</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Expired</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $stats['totalMembers'] > 0 ? ($stats['expiredMembers'] / $stats['totalMembers'] * 100) : 0 }}%"></div>
                    </div>
                    <span class="font-bold">{{ $stats['expiredMembers'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Members -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Recently Verified Members</h2>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse($recentMembers as $member)
                <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50">
                    <div>
                        <p class="font-semibold">{{ $member->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $member->email }}</p>
                    </div>
                    <a href="{{ route('admin.members.show', $member) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">View</a>
                </div>
            @empty
                <p class="text-gray-600 text-center py-4">No recently verified members</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Recent Event Registrations</h2>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse($recentRegistrations as $registration)
                <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50">
                    <div>
                        <p class="font-semibold">{{ $registration->user->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $registration->event->title }}</p>
                    </div>
                    <span class="inline-block px-3 py-1 bg-{{ $registration->status === 'registered' ? 'green' : 'yellow' }}-100 text-{{ $registration->status === 'registered' ? 'green' : 'yellow' }}-800 text-xs font-semibold rounded-full">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-600 text-center py-4">No recent registrations</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
