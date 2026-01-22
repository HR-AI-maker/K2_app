@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                ← Back to Products
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Review Product</h1>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Product Details (Main) -->
            <div class="lg:col-span-2">
                <!-- Product Images -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="p-6">
                        @if($product->images && count($product->images) > 0)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                            </div>
                            @if(count($product->images) > 1)
                                <div class="flex gap-2 overflow-x-auto">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded cursor-pointer hover:opacity-75">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                <span class="text-6xl">📦</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ ucfirst($product->category) }} • Added {{ $product->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        <!-- Price & Stock -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Price</p>
                                <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format($product->price, 0) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Stock</p>
                                @if($product->is_unlimited_stock)
                                    <p class="text-2xl font-bold text-green-600">Unlimited</p>
                                @else
                                    <p class="text-2xl font-bold text-gray-900">{{ $product->stock_quantity }} units</p>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Description</p>
                            <p class="text-gray-700 leading-relaxed">{{ $product->description ?? 'No description provided' }}</p>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Status</p>
                            @if($product->status === 'pending')
                                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    ⏳ Pending Approval
                                </span>
                            @elseif($product->status === 'published')
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    ✅ Published
                                </span>
                            @elseif($product->status === 'rejected')
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                    ❌ Rejected
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                    {{ ucfirst($product->status) }}
                                </span>
                            @endif
                        </div>

                        <!-- Rejection Reason -->
                        @if($product->status === 'rejected' && $product->rejection_reason)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-red-900 mb-2">Rejection Reason</p>
                                <p class="text-red-700">{{ $product->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Vendor Information -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="font-semibold text-gray-900">Vendor Information</h3>
                    </div>
                    <div class="px-6 py-6 space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Business Name</p>
                            <p class="text-gray-900 font-medium">{{ $product->vendor->business_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Person</p>
                            <p class="text-gray-900">{{ $product->vendor->contact_person ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-gray-900">{{ $product->vendor->vendorUser->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone</p>
                            <p class="text-gray-900">{{ $product->vendor->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($product->status === 'pending' || $product->status === 'rejected')
                    <div x-data="{ showRejectForm: false }" class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="font-semibold text-gray-900">Actions</h3>
                        </div>
                        <div class="px-6 py-6 space-y-3">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition">
                                    ✅ Approve Product
                                </button>
                            </form>

                            <!-- Reject Toggle -->
                            <button type="button" @click="showRejectForm = !showRejectForm" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                ❌ Reject Product
                            </button>

                            <!-- Reject Form -->
                            <div x-show="showRejectForm" x-cloak class="mt-4 pt-4 border-t border-gray-200">
                                <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                            Reason for Rejection
                                        </label>
                                        <textarea
                                            name="reason"
                                            id="reason"
                                            rows="4"
                                            placeholder="Explain why this product is being rejected (minimum 10 characters)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                            required
                                        ></textarea>
                                        @error('reason')
                                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                            Confirm Rejection
                                        </button>
                                        <button type="button" @click="showRejectForm = false" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif($product->status === 'published')
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="font-semibold text-gray-900">Status</h3>
                        </div>
                        <div class="px-6 py-6">
                            <p class="text-sm text-gray-600 mb-4">This product has been approved and is now published in the marketplace.</p>
                            @if($product->approved_at)
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Approved:</span> {{ $product->approved_at->format('d M Y H:i') }}
                                </p>
                            @endif
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
