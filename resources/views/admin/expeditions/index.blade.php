@extends('layouts.admin')

@section('title', 'Expeditions Management')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Expeditions Management</h1>
            <p class="text-gray-600 mt-2">Manage and organize alpine expeditions</p>
        </div>
        <a href="{{ route('admin.expeditions.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
            ➕ Create Expedition
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Open</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['open'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Closed</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['closed'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Planning</p>
        <p class="text-2xl font-bold text-purple-600">{{ $stats['planning'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Cancelled</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Completed</p>
        <p class="text-2xl font-bold text-gray-600">{{ $stats['completed'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.expeditions.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Title, location..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600">
                    <option value="">All Statuses</option>
                    <option value="planning" {{ request('status') === 'planning' ? 'selected' : '' }}>Planning</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Difficulty Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                <select name="difficulty" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600">
                    <option value="">All Levels</option>
                    <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                    <option value="expert" {{ request('difficulty') === 'expert' ? 'selected' : '' }}>Expert</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="start_date" {{ request('sort_by') === 'start_date' ? 'selected' : '' }}>Start Date</option>
                    <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Title</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Expeditions Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($expeditions->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Region</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Difficulty</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Participants</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Applications</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($expeditions as $expedition)
                    @php
                        $appCount = $expedition->applications()->count();
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.expeditions.show', $expedition) }}" class="text-blue-600 hover:underline font-medium">
                                {{ Str::limit($expedition->title, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $expedition->region }}</td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $colors = [
                                    'beginner' => 'bg-green-100 text-green-800',
                                    'intermediate' => 'bg-yellow-100 text-yellow-800',
                                    'advanced' => 'bg-orange-100 text-orange-800',
                                    'expert' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$expedition->difficulty_level] ?? 'bg-gray-100' }}">
                                {{ ucfirst($expedition->difficulty_level) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusColors = [
                                    'planning' => 'bg-purple-100 text-purple-800',
                                    'open' => 'bg-green-100 text-green-800',
                                    'closed' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$expedition->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($expedition->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $expedition->start_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $expedition->applications()->where('status', 'approved')->count() }} / {{ $expedition->max_participants }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.expeditions.applications', $expedition) }}" class="text-blue-600 hover:underline">
                                {{ $appCount }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <a href="{{ route('admin.expeditions.show', $expedition) }}" class="text-blue-600 hover:underline mr-3">View</a>
                            <a href="{{ route('admin.expeditions.edit', $expedition) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No expeditions found</p>
            <a href="{{ route('admin.expeditions.create') }}" class="text-blue-600 hover:underline mt-4 inline-block">
                Create the first expedition
            </a>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $expeditions->links() }}
</div>
@endsection
