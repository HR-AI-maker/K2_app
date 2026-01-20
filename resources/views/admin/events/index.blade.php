@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Events Management</h1>
            <p class="text-gray-600 mt-2">Manage, create, and track all events</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            ➕ Create Event
        </a>
    </div>
</div>

<!-- Event Statistics -->
<div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Draft</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['draft'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Upcoming</p>
        <p class="text-2xl font-bold text-purple-600">{{ $stats['upcoming'] }}</p>
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
    <form method="GET" action="{{ route('admin.events.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, location..." class="input">
            </div>

            <!-- Event Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                <select name="event_type" class="input">
                    <option value="">All Types</option>
                    <option value="championship" @selected(request('event_type') === 'championship')>Championship</option>
                    <option value="training" @selected(request('event_type') === 'training')>Training</option>
                    <option value="expedition" @selected(request('event_type') === 'expedition')>Expedition</option>
                    <option value="meetup" @selected(request('event_type') === 'meetup')>Meetup</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input">
                    <option value="">All Statuses</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                </select>
            </div>

            <!-- Region Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                <select name="region" class="input">
                    <option value="">All Regions</option>
                    @foreach($regions as $region)
                        <option value="{{ $region }}" @selected(request('region') === $region)>{{ $region }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Start Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="input">
            </div>

            <!-- End Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="input">
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Apply Filters
            </button>
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Events Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Participants</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($events as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $event->title }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($event->event_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $event->location }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $event->start_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold">
                                @php
                                    $registered = $event->registrations()->where('status', 'registered')->count();
                                    $max = $event->max_participants;
                                @endphp
                                {{ $registered }}/{{ $max }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($event->status === 'published') bg-green-100 text-green-800
                                @elseif($event->status === 'draft') bg-yellow-100 text-yellow-800
                                @elseif($event->status === 'cancelled') bg-red-100 text-red-800
                                @elseif($event->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.events.show', $event) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No events found. <a href="{{ route('admin.events.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Create your first event</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($events->count() > 0)
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
