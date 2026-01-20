@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
            <a href="{{ route('admin.user-management.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add New User
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Active Members</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['active_members'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Pending Payments</p>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_payments'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Vendors</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['vendors'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Admins</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['admins'] }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.user-management.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <input
                            type="text"
                            name="search"
                            placeholder="Search by name, email..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Roles</option>
                            <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="vendor" {{ request('role') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Membership Status -->
                    <div>
                        <select name="membership_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('membership_status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending_payment" {{ request('membership_status') === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="suspended" {{ request('membership_status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <!-- Membership Tier -->
                    <div>
                        <select name="membership_tier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Tiers</option>
                            @foreach($membershipTiers as $tier)
                                <option value="{{ $tier->name }}" {{ request('membership_tier') === $tier->name ? 'selected' : '' }}>
                                    {{ $tier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.user-management.index') }}" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                            Reset
                        </a>
                    </div>
                </div>

                <!-- Export Button -->
                <div class="flex justify-end">
                    <form method="GET" action="{{ route('admin.user-management.export') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                            📊 Export CSV
                        </button>
                    </form>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($users->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">User</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Email</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Role</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Membership</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Joined</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $user->full_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $user->phone }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'vendor') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-medium text-gray-900">{{ $user->membership_tier }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($user->membership_status === 'active') bg-green-100 text-green-800
                                        @elseif($user->membership_status === 'pending_payment') bg-orange-100 text-orange-800
                                        @elseif($user->membership_status === 'suspended') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $user->membership_status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.user-management.show', $user) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No users found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
