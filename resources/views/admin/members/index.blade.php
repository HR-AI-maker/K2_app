@extends('layouts.admin')

@section('title', 'Members Management')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Members Management</h1>
            <p class="text-gray-600 mt-2">Manage and verify member accounts</p>
        </div>
    </div>
</div>

<!-- Member Statistics -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Active</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Expired</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['expired'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Suspended</p>
        <p class="text-2xl font-bold text-purple-600">{{ $stats['suspended'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.members.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, phone..." class="input">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input">
                    <option value="">All Statuses</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                    <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                </select>
            </div>

            <!-- Tier Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Membership Tier</label>
                <select name="tier" class="input">
                    <option value="">All Tiers</option>
                    <option value="pending" @selected(request('tier') === 'pending')>Pending</option>
                    <option value="standard" @selected(request('tier') === 'standard')>Standard</option>
                    <option value="premium" @selected(request('tier') === 'premium')>Premium</option>
                    <option value="lifetime" @selected(request('tier') === 'lifetime')>Lifetime</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                <select name="type" class="input">
                    <option value="">All Types</option>
                    <option value="local" @selected(request('type') === 'local')>Local</option>
                    <option value="foreign" @selected(request('type') === 'foreign')>Foreign</option>
                </select>
            </div>

            <!-- Discipline Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discipline</label>
                <select name="discipline" class="input">
                    <option value="">All Disciplines</option>
                    <option value="trekking" @selected(request('discipline') === 'trekking')>Trekking</option>
                    <option value="rock" @selected(request('discipline') === 'rock')>Rock Climbing</option>
                    <option value="ice" @selected(request('discipline') === 'ice')>Ice Climbing</option>
                    <option value="mountaineering" @selected(request('discipline') === 'mountaineering')>Mountaineering</option>
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Apply Filters
            </button>
            <a href="{{ route('admin.members.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Members Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tier</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($members as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $member->full_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $member->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($member->membership_status === 'active') bg-green-100 text-green-800
                                @elseif($member->membership_status === 'expired') bg-red-100 text-red-800
                                @elseif($member->membership_status === 'suspended') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($member->membership_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge">
                                {{ ucfirst($member->membership_tier) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            @if($member->membership_verified_at)
                                ✓ {{ ucfirst($member->user_type) }}
                            @else
                                ⏳ Pending
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $member->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.members.show', $member) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No members found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($members->count() > 0)
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
