@extends('layouts.admin')

@section('title', 'Vendor Management')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">🏪 Vendor Directory</h1>
            <p class="text-gray-600 mt-2">Manage guides, transportation, lodging, and equipment vendors</p>
        </div>
        <a href="{{ route('admin.vendors.create') }}" class="btn-primary">
            ➕ Add Vendor
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : '' }}">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'verified' ? 'ring-2 ring-green-600' : '' }}">
        <p class="text-gray-600 text-sm">Verified</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'suspended' ? 'ring-2 ring-red-600' : '' }}">
        <p class="text-gray-600 text-sm">Suspended</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['suspended'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.vendors.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>All Vendors</option>
                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $currentStatus === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="suspended" {{ $currentStatus === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <!-- Business Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="business_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="guide" {{ $currentBusinessType === 'guide' ? 'selected' : '' }}>Guide</option>
                    <option value="transport" {{ $currentBusinessType === 'transport' ? 'selected' : '' }}>Transport</option>
                    <option value="lodging" {{ $currentBusinessType === 'lodging' ? 'selected' : '' }}>Lodging</option>
                    <option value="equipment" {{ $currentBusinessType === 'equipment' ? 'selected' : '' }}>Equipment</option>
                    <option value="other" {{ $currentBusinessType === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Business name, contact..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="verified_at" {{ request('sort_by') === 'verified_at' ? 'selected' : '' }}>Recently Verified</option>
                    <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
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

<!-- Vendors Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($vendors->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Business Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Contact</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Rating</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($vendors as $vendor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold">{{ $vendor->business_name }}</p>
                                @if ($vendor->is_certified)
                                    <p class="text-xs text-yellow-600">⭐ Certified</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="badge
                                @if ($vendor->business_type === 'guide') bg-blue-100 text-blue-800
                                @elseif ($vendor->business_type === 'transport') bg-purple-100 text-purple-800
                                @elseif ($vendor->business_type === 'lodging') bg-orange-100 text-orange-800
                                @elseif ($vendor->business_type === 'equipment') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($vendor->business_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-semibold">{{ $vendor->contact_person }}</p>
                            <p class="text-gray-600">{{ $vendor->email }}</p>
                            <p class="text-gray-600">{{ $vendor->phone }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($vendor->status === 'pending')
                                <span class="badge bg-yellow-100 text-yellow-800">⏳ Pending</span>
                            @elseif ($vendor->status === 'verified')
                                <span class="badge bg-green-100 text-green-800">✓ Verified</span>
                            @elseif ($vendor->status === 'suspended')
                                <span class="badge bg-red-100 text-red-800">✗ Suspended</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($vendor->rating)
                                <div class="flex items-center gap-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($vendor->rating))
                                            <span class="text-yellow-400">★</span>
                                        @else
                                            <span class="text-gray-300">☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-xs">{{ number_format($vendor->rating, 1) }} / 5.0</p>
                            @else
                                <span class="text-gray-500">No rating</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-blue-600 hover:text-blue-800 block">
                                View
                            </a>
                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-blue-600 hover:text-blue-800 block">
                                Edit
                            </a>
                            @if ($vendor->status === 'pending')
                                <form method="POST" action="{{ route('admin.vendors.verify', $vendor) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full">
                                        Verify
                                    </button>
                                </form>
                            @endif
                            @if ($vendor->status === 'verified')
                                <form method="POST" action="{{ route('admin.vendors.suspend', $vendor) }}" class="inline" onsubmit="return confirm('Suspend this vendor?');">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 block w-full">
                                        Suspend
                                    </button>
                                </form>
                            @elseif ($vendor->status === 'suspended')
                                <form method="POST" action="{{ route('admin.vendors.reactivate', $vendor) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 block w-full">
                                        Reactivate
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" class="inline" onsubmit="return confirm('Delete this vendor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 block w-full">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No vendors found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters or create a new vendor</p>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $vendors->links() }}
</div>
@endsection
