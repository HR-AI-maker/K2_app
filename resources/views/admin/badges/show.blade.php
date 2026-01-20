@extends('layouts.admin')

@section('title', 'Badge: ' . $badge->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.badges.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Badges
    </a>
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $badge->name }}</h1>
            <div class="flex gap-2 mt-2">
                <span class="badge
                    @if ($badge->tier === 'bronze') bg-yellow-100 text-yellow-800
                    @elseif ($badge->tier === 'silver') bg-gray-100 text-gray-800
                    @elseif ($badge->tier === 'gold') bg-yellow-100 text-yellow-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    {{ ucfirst($badge->tier) }}
                </span>
            </div>
        </div>
        <a href="{{ route('admin.badges.edit', $badge) }}" class="btn-primary">
            ✎ Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Badge Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <div class="text-center mb-6">
                <p class="text-8xl">{{ $badge->icon_path }}</p>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Description</p>
                    <p class="text-gray-700">{{ $badge->description }}</p>
                </div>

                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600 mb-1">Earning Criteria</p>
                    <p class="font-semibold text-gray-900">{{ str_replace('_', ' ', ucfirst($badge->criteria)) }}</p>
                </div>

                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600 mb-1">Badge Tier</p>
                    <p class="font-semibold capitalize text-gray-900">{{ $badge->tier }}</p>
                </div>
            </div>
        </div>

        <!-- Users Who Earned This Badge -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6">Users Who Earned This Badge</h2>

            @if ($badge->users->count() > 0)
                <div class="space-y-3">
                    @foreach ($badge->users as $user)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div>
                                <p class="font-semibold">{{ $user->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('admin.members.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600">No users have earned this badge yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Badge Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Badge Information</h3>

            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-semibold">{{ $badge->name }}</p>
                </div>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-600">Tier</p>
                    <p class="font-semibold capitalize">{{ $badge->tier }}</p>
                </div>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-600">Total Users Earned</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $badge->users->count() }}</p>
                </div>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-600">Created</p>
                    <p class="text-sm">{{ $badge->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Tier Guide -->
        <div class="bg-gradient-to-br
            @if ($badge->tier === 'bronze') from-yellow-50 to-yellow-100 border border-yellow-300
            @elseif ($badge->tier === 'silver') from-gray-50 to-gray-100 border border-gray-300
            @elseif ($badge->tier === 'gold') from-yellow-50 to-amber-100 border border-amber-300
            @else from-purple-50 to-purple-100 border border-purple-300
            @endif rounded-lg p-6">
            <h3 class="font-bold mb-2
                @if ($badge->tier === 'bronze') text-yellow-900
                @elseif ($badge->tier === 'silver') text-gray-900
                @elseif ($badge->tier === 'gold') text-amber-900
                @else text-purple-900
                @endif">
                {{ ucfirst($badge->tier) }} Tier Badge
            </h3>
            <p class="text-sm
                @if ($badge->tier === 'bronze') text-yellow-800
                @elseif ($badge->tier === 'silver') text-gray-800
                @elseif ($badge->tier === 'gold') text-amber-800
                @else text-purple-800
                @endif">
                @if ($badge->tier === 'bronze')
                    Entry-level achievement for new or casual users
                @elseif ($badge->tier === 'silver')
                    Intermediate achievement for active members
                @elseif ($badge->tier === 'gold')
                    Advanced achievement for dedicated members
                @else
                    Elite achievement for exceptional members
                @endif
            </p>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold mb-4">Actions</h3>

            <div class="space-y-2">
                <a href="{{ route('admin.badges.edit', $badge) }}" class="block w-full px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 text-center font-semibold transition">
                    ✎ Edit Badge
                </a>

                <form method="POST" action="{{ route('admin.badges.destroy', $badge) }}" class="block" onsubmit="return confirm('Delete this badge? Users who earned it will keep it.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 font-semibold transition">
                        🗑️ Delete Badge
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
