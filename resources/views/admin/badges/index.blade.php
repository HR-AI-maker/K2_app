@extends('layouts.admin')

@section('title', 'Badge Management')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">🏆 Badge Management</h1>
            <p class="text-gray-600 mt-2">Create and manage achievement badges</p>
        </div>
        <a href="{{ route('admin.badges.create') }}" class="btn-primary">
            ➕ Create Badge
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentTier === 'bronze' ? 'ring-2 ring-yellow-600' : '' }}">
        <p class="text-gray-600 text-sm">Bronze</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['bronze'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentTier === 'silver' ? 'ring-2 ring-gray-400' : '' }}">
        <p class="text-gray-600 text-sm">Silver</p>
        <p class="text-2xl font-bold text-gray-400">{{ $stats['silver'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentTier === 'gold' ? 'ring-2 ring-yellow-500' : '' }}">
        <p class="text-gray-600 text-sm">Gold</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $stats['gold'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentTier === 'platinum' ? 'ring-2 ring-purple-600' : '' }}">
        <p class="text-gray-600 text-sm">Platinum</p>
        <p class="text-2xl font-bold text-purple-600">{{ $stats['platinum'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.badges.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Tier Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tier</label>
                <select name="tier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Tiers</option>
                    <option value="bronze" {{ $currentTier === 'bronze' ? 'selected' : '' }}>Bronze</option>
                    <option value="silver" {{ $currentTier === 'silver' ? 'selected' : '' }}>Silver</option>
                    <option value="gold" {{ $currentTier === 'gold' ? 'selected' : '' }}>Gold</option>
                    <option value="platinum" {{ $currentTier === 'platinum' ? 'selected' : '' }}>Platinum</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Badge name..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Badges Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($badges as $badge)
        <a href="{{ route('admin.badges.show', $badge) }}" class="card hover:shadow-lg transition-shadow">
            <!-- Badge Icon -->
            <div class="text-center mb-4">
                <p class="text-6xl">{{ $badge->icon_path }}</p>
            </div>

            <!-- Badge Name -->
            <h3 class="text-lg font-bold text-center mb-2">{{ $badge->name }}</h3>

            <!-- Tier Badge -->
            <div class="text-center mb-3">
                <span class="badge
                    @if ($badge->tier === 'bronze') bg-yellow-100 text-yellow-800
                    @elseif ($badge->tier === 'silver') bg-gray-100 text-gray-800
                    @elseif ($badge->tier === 'gold') bg-yellow-100 text-yellow-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    {{ ucfirst($badge->tier) }}
                </span>
            </div>

            <!-- Description -->
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $badge->description }}</p>

            <!-- Stats -->
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <div class="text-sm">
                    <p class="text-gray-600">Users Earned</p>
                    <p class="text-xl font-bold text-blue-600">{{ $badge->users_count ?? 0 }}</p>
                </div>
                <div class="text-right">
                    <a href="{{ route('admin.badges.edit', $badge) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold block">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.badges.destroy', $badge) }}" class="inline" onsubmit="return confirm('Delete this badge?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-600 text-lg">No badges found</p>
            <p class="text-sm text-gray-500 mt-2">Create your first badge to get started</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $badges->links() }}
</div>
@endsection
