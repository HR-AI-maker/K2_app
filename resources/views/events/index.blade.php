@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Upcoming Events</h1>
            <p class="text-blue-100">Join our community for unforgettable alpine experiences</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <form method="GET" class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Title, location, region..."
                        class="input"
                    >
                </div>

                <!-- Event Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="event_type" class="input">
                        <option value="">All Types</option>
                        <option value="championship" {{ request('event_type') === 'championship' ? 'selected' : '' }}>Championship</option>
                        <option value="training" {{ request('event_type') === 'training' ? 'selected' : '' }}>Training</option>
                        <option value="expedition" {{ request('event_type') === 'expedition' ? 'selected' : '' }}>Expedition</option>
                        <option value="meetup" {{ request('event_type') === 'meetup' ? 'selected' : '' }}>Meetup</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" {{ request('region') === $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">When</label>
                    <select name="filter" class="input">
                        <option value="upcoming" {{ request('filter', 'upcoming') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="past" {{ request('filter') === 'past' ? 'selected' : '' }}>Past Events</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>

        <!-- Events Grid -->
        @if ($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($events as $event)
                    <div class="card hover:shadow-lg transition-shadow">
                        <!-- Event Type Badge -->
                        <div class="mb-3">
                            <span class="badge bg-blue-100 text-blue-800">
                                {{ ucfirst($event->event_type) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            {{ $event->title }}
                        </h3>

                        <!-- Location -->
                        <p class="text-sm text-gray-600 mb-2">
                            📍 {{ $event->location }}, {{ $event->region }}
                        </p>

                        <!-- Dates -->
                        <p class="text-sm text-gray-600 mb-3">
                            📅 {{ $event->start_date->format('M d, Y') }}
                            @if ($event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                                - {{ $event->end_date->format('M d, Y') }}
                            @endif
                        </p>

                        <!-- Pricing -->
                        <div class="mb-3 p-2 bg-gray-50 rounded">
                            <p class="text-xs text-gray-600">Starting from</p>
                            <p class="text-lg font-bold text-blue-600">
                                Rs. {{ number_format($event->price_member) }}
                                <span class="text-xs text-gray-500">/ member</span>
                            </p>
                        </div>

                        <!-- Availability -->
                        @php
                            $registered = $event->registrations()->where('status', 'registered')->count();
                            $available = max(0, $event->max_participants - $registered);
                        @endphp

                        <div class="mb-4">
                            @if ($available > 0)
                                <div class="text-xs text-green-600 font-semibold mb-1">
                                    {{ $available }} slots available
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div
                                        class="bg-green-500 h-2 rounded-full"
                                        style="width: {{ ($registered / $event->max_participants) * 100 }}%"
                                    ></div>
                                </div>
                            @else
                                <div class="text-xs text-red-600 font-semibold">
                                    🔴 Waitlist Available
                                </div>
                            @endif
                        </div>

                        <!-- View Button -->
                        <a
                            href="{{ route('events.show', $event) }}"
                            class="btn-primary w-full text-center block"
                        >
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                {{ $events->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card text-center py-12">
                <p class="text-2xl font-bold text-gray-600 mb-2">No events found</p>
                <p class="text-gray-500 mb-4">Try adjusting your filters</p>
                <a href="{{ route('events.index') }}" class="btn-primary inline-block">
                    Clear Filters
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
