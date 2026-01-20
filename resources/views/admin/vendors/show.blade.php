@extends('layouts.admin')

@section('title', 'Vendor: ' . $vendor->business_name)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.vendors.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Vendors
    </a>
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $vendor->business_name }}</h1>
            <div class="flex gap-2 mt-2">
                @if ($vendor->status === 'pending')
                    <span class="badge bg-yellow-100 text-yellow-800">⏳ Pending</span>
                @elseif ($vendor->status === 'verified')
                    <span class="badge bg-green-100 text-green-800">✓ Verified</span>
                @elseif ($vendor->status === 'suspended')
                    <span class="badge bg-red-100 text-red-800">✗ Suspended</span>
                @endif
                @if ($vendor->is_certified)
                    <span class="badge bg-yellow-100 text-yellow-800">⭐ Certified</span>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn-primary">
            ✎ Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Business Information -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6">Business Information</h2>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Contact Person</p>
                    <p class="font-semibold">{{ $vendor->contact_person }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Business Type</p>
                    <p class="font-semibold capitalize">{{ $vendor->business_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Email</p>
                    <p class="font-semibold">
                        <a href="mailto:{{ $vendor->email }}" class="text-blue-600 hover:underline">
                            {{ $vendor->email }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Phone</p>
                    <p class="font-semibold">
                        <a href="tel:{{ $vendor->phone }}" class="text-blue-600 hover:underline">
                            {{ $vendor->phone }}
                        </a>
                    </p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">📍 Location</p>
                <p class="font-semibold">{{ $vendor->address }}</p>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-4">Description</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $vendor->description }}</p>
        </div>

        <!-- Certification -->
        @if ($vendor->is_certified)
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-4 text-yellow-900">⭐ Certification Details</h2>
                <p class="text-gray-700 leading-relaxed">{{ $vendor->certification_details ?? 'Vendor is certified and verified.' }}</p>
            </div>
        @endif

        <!-- Services -->
        @if ($vendor->services->count() > 0)
            <div class="bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-bold mb-6">Services</h2>

                <div class="space-y-3">
                    @foreach ($vendor->services as $service)
                        <div class="border-l-4 border-green-500 pl-4 py-2">
                            <p class="font-semibold">{{ $service->service_name }}</p>
                            <p class="text-sm text-gray-600">{{ $service->description }}</p>
                            @if ($service->price)
                                <p class="text-sm font-semibold text-green-600 mt-1">PKR {{ number_format($service->price) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status & Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Status & Actions</h3>

            <div class="space-y-2 mb-6 pb-6 border-b border-gray-200">
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="font-semibold capitalize">{{ $vendor->status }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Bookings</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $vendor->total_bookings ?? 0 }}</p>
                </div>
            </div>

            <div class="space-y-2">
                @if ($vendor->status === 'pending')
                    <form method="POST" action="{{ route('admin.vendors.verify', $vendor) }}" class="block">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                            ✓ Verify Vendor
                        </button>
                    </form>
                @endif

                @if ($vendor->status === 'verified')
                    <form method="POST" action="{{ route('admin.vendors.suspend', $vendor) }}" class="block" onsubmit="return confirm('Suspend this vendor?');">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold">
                            ⚠️ Suspend Vendor
                        </button>
                    </form>
                @elseif ($vendor->status === 'suspended')
                    <form method="POST" action="{{ route('admin.vendors.reactivate', $vendor) }}" class="block">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                            🔄 Reactivate
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" class="block" onsubmit="return confirm('Delete this vendor?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        🗑️ Delete Vendor
                    </button>
                </form>
            </div>
        </div>

        <!-- Rating -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Rating</h3>

            <div class="text-center mb-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-center gap-1 mb-2">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < floor($vendor->rating ?? 0))
                            <span class="text-3xl text-yellow-400">★</span>
                        @else
                            <span class="text-3xl text-gray-300">☆</span>
                        @endif
                    @endfor
                </div>
                <p class="text-2xl font-bold">{{ $vendor->rating ? number_format($vendor->rating, 1) : 'Unrated' }}</p>
            </div>

            <form method="POST" action="{{ route('admin.vendors.updateRating', $vendor) }}" class="space-y-2">
                @csrf
                <label for="rating" class="block text-sm font-semibold text-gray-900">Update Rating (0-5)</label>
                <div class="flex gap-2">
                    <input
                        type="number"
                        id="rating"
                        name="rating"
                        value="{{ $vendor->rating }}"
                        min="0"
                        max="5"
                        step="0.1"
                        class="input flex-1"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Verification Info -->
        @if ($vendor->verified_at)
            <div class="bg-green-50 border border-green-300 rounded-lg p-6">
                <h3 class="text-lg font-bold text-green-900 mb-3">Verification</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-600">Verified By</p>
                        <p class="font-semibold">{{ $vendor->verifiedBy->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Verified On</p>
                        <p class="font-semibold">{{ $vendor->verified_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
