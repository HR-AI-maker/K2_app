@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">👥 Member Management</h1>
                    <p class="text-gray-600 mt-2">Review and manage members</p>
                </div>
                <a href="{{ route('admin.members.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    + Add New Member
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
            <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'all' ? 'ring-2 ring-blue-600' : '' }}">
                <p class="text-gray-600 text-sm">Total</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'active' ? 'ring-2 ring-green-600' : '' }}">
                <p class="text-gray-600 text-sm">Active</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'pending_verification' ? 'ring-2 ring-yellow-600' : '' }}">
                <p class="text-gray-600 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_verification'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'expired' ? 'ring-2 ring-orange-600' : '' }}">
                <p class="text-gray-600 text-sm">Expired</p>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['expired'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'suspended' ? 'ring-2 ring-red-600' : '' }}">
                <p class="text-gray-600 text-sm">Suspended</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['suspended'] }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <form method="GET" action="{{ route('admin.members.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                            <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>All Members</option>
                            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending_verification" {{ $currentStatus === 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                            <option value="expired" {{ $currentStatus === 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="suspended" {{ $currentStatus === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tier</label>
                        <select name="membership_tier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                            <option value="">All Tiers</option>
                            <option value="standard" {{ request('membership_tier') === 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="premium" {{ request('membership_tier') === 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="lifetime" {{ request('membership_tier') === 'lifetime' ? 'selected' : '' }}>Elite</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Member</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Email, name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                        <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none">
                            <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="first_name" {{ request('sort_by') === 'first_name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Members Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($members->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Member</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tier</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($members as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->phone }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($member->membership_tier === 'standard')
                                <span class="badge bg-blue-100 text-blue-800">Standard</span>
                            @elseif($member->membership_tier === 'premium')
                                <span class="badge bg-purple-100 text-purple-800">Premium</span>
                            @else
                                <span class="badge bg-yellow-100 text-yellow-800">Elite</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($member->membership_status === 'active')
                                <span class="badge bg-green-100 text-green-800">✓ Active</span>
                            @elseif($member->membership_status === 'expired')
                                <span class="badge bg-orange-100 text-orange-800">⏳ Expired</span>
                            @elseif($member->membership_status === 'suspended')
                                <span class="badge bg-red-100 text-red-800">✗ Suspended</span>
                            @else
                                <span class="badge bg-yellow-100 text-yellow-800">⏳ Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $member->created_at->format('M d, Y') }}<br>
                            <span class="text-gray-500 text-xs">{{ $member->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <a href="{{ route('admin.members.show', $member->id) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $members->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No members found</p>
                <p class="text-sm text-gray-500 mt-2">Adjust your filters to see members</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
