@extends('layouts.app')

@section('title', 'Vendor Directory')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Vendor Directory</h1>
            <p class="text-green-100">Find trusted guides, transportation, lodging, and equipment providers</p>
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
                        placeholder="Business name, contact..."
                        class="input"
                    >
                </div>

                <!-- Business Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="business_type" class="input">
                        <option value="">All Types</option>
                        <option value="guide" {{ $currentBusinessType === 'guide' ? 'selected' : '' }}>Guide</option>
                        <option value="transport" {{ $currentBusinessType === 'transport' ? 'selected' : '' }}>Transport</option>
                        <option value="lodging" {{ $currentBusinessType === 'lodging' ? 'selected' : '' }}>Lodging</option>
                        <option value="equipment" {{ $currentBusinessType === 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="other" {{ $currentBusinessType === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" {{ $currentRegion === $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                    <select name="sort_by" class="input">
                        <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="bookings" {{ request('sort_by') === 'bookings' ? 'selected' : '' }}>Most Booked</option>
                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Alphabetical</option>
                        <option value="recent" {{ request('sort_by') === 'recent' ? 'selected' : '' }}>Recently Verified</option>
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

        <!-- Vendors Grid -->
        @if ($vendors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($vendors as $vendor)
                    <a href="{{ route('vendors.show', $vendor) }}" class="card hover:shadow-lg transition-shadow hover:scale-105">
                        <!-- Type Badge & Certification -->
                        <div class="flex justify-between items-start mb-3">
                            <span class="badge
                                @if ($vendor->business_type === 'guide') bg-blue-100 text-blue-800
                                @elseif ($vendor->business_type === 'transport') bg-purple-100 text-purple-800
                                @elseif ($vendor->business_type === 'lodging') bg-orange-100 text-orange-800
                                @elseif ($vendor->business_type === 'equipment') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if ($vendor->business_type === 'guide') 👨‍🏫 Guide
                                @elseif ($vendor->business_type === 'transport') 🚗 Transport
                                @elseif ($vendor->business_type === 'lodging') 🏨 Lodging
                                @elseif ($vendor->business_type === 'equipment') 🎒 Equipment
                                @else 🏪 {{ ucfirst($vendor->business_type) }}
                                @endif
                            </span>
                            @if ($vendor->is_certified)
                                <span class="text-yellow-500 text-lg">⭐</span>
                            @endif
                        </div>

                        <!-- Business Name -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            {{ $vendor->business_name }}
                        </h3>

                        <!-- Contact Info -->
                        <p class="text-sm text-gray-600 mb-2">
                            👤 {{ $vendor->contact_person }}
                        </p>

                        <!-- Description -->
                        <p class="text-sm text-gray-700 mb-3 line-clamp-2">
                            {{ $vendor->description }}
                        </p>

                        <!-- Location -->
                        <p class="text-sm text-gray-600 mb-3">
                            📍 {{ $vendor->address }}
                        </p>

                        <!-- Rating & Bookings -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <div>
                                <div class="flex items-center gap-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($vendor->rating ?? 0))
                                            <span class="text-yellow-400">★</span>
                                        @elseif ($i < $vendor->rating ?? 0)
                                            <span class="text-yellow-300">✧</span>
                                        @else
                                            <span class="text-gray-300">☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-600">{{ $vendor->rating ? number_format($vendor->rating, 1) : 'No rating' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-blue-600">{{ $vendor->total_bookings ?? 0 }}</p>
                                <p class="text-xs text-gray-600">bookings</p>
                            </div>
                        </div>

                        <!-- Certification Badge -->
                        @if ($vendor->is_certified)
                            <div class="mt-3 p-2 bg-yellow-50 rounded text-xs text-yellow-800 font-semibold text-center">
                                ✓ Certified Vendor
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                {{ $vendors->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-6xl mb-4">🏪</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Vendors Found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your filters to see available vendors</p>
                <a href="{{ route('vendors.index') }}" class="btn-primary">
                    View All Vendors
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
