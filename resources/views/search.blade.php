@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Search Form -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Search</h1>
            <form method="GET" action="{{ route('search') }}" class="flex gap-2">
                <input
                    type="text"
                    name="q"
                    placeholder="Search events, expeditions, vendors..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                    value="{{ $query ?? '' }}"
                    required
                >
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Search
                </button>
            </form>
        </div>

        <!-- Results -->
        @if (!empty($query))
            <!-- Events Results -->
            @if (!empty($events) && $events->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">📅 Events ({{ $events->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($events as $event)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32 flex items-center justify-center text-white text-4xl">
                                    📅
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $event->location }}</p>
                                    <p class="text-sm text-gray-500 mb-3">{{ $event->start_date->format('M d, Y') }}</p>
                                    <a href="{{ route('events.show', $event) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                                        View Event
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Expeditions Results -->
            @if (!empty($expeditions) && $expeditions->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">🏔️ Expeditions ({{ $expeditions->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($expeditions as $expedition)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-32 flex items-center justify-center text-white text-4xl">
                                    🏔️
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">{{ $expedition->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $expedition->location }}</p>
                                    <p class="text-sm text-gray-500 mb-1">Difficulty: <span class="font-semibold">{{ ucfirst($expedition->difficulty_level) }}</span></p>
                                    <p class="text-sm text-gray-500 mb-3">{{ $expedition->start_date->format('M d, Y') }}</p>
                                    <a href="{{ route('expeditions.show', $expedition) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-semibold">
                                        View Expedition
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Vendors Results -->
            @if (!empty($vendors) && $vendors->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">👥 Vendors ({{ $vendors->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($vendors as $vendor)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-32 flex items-center justify-center text-white text-4xl">
                                    👥
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">{{ $vendor->business_name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ ucfirst(str_replace('_', ' ', $vendor->business_type)) }}</p>
                                    <p class="text-sm text-gray-500 mb-1">{{ $vendor->address }}</p>
                                    <p class="text-sm text-gray-500 mb-3">
                                        @if ($vendor->is_certified)
                                            <span class="text-green-600 font-semibold">✓ Certified</span>
                                        @else
                                            <span class="text-gray-500">Pending certification</span>
                                        @endif
                                    </p>
                                    <a href="{{ route('vendors.show', $vendor) }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-semibold">
                                        View Vendor
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- No Results -->
            @if (
                (empty($events) || $events->count() === 0) &&
                (empty($expeditions) || $expeditions->count() === 0) &&
                (empty($vendors) || $vendors->count() === 0)
            )
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-2xl text-gray-600 mb-2">No results found</p>
                    <p class="text-gray-500 mb-6">We couldn't find anything matching "{{ $query }}"</p>
                    <a href="{{ route('events.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Browse Events
                    </a>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-2xl text-gray-600 mb-2">Start searching</p>
                <p class="text-gray-500">Enter a search term to find events, expeditions, or vendors</p>
            </div>
        @endif
    </div>
</div>
@endsection
