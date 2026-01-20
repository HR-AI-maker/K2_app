@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back</a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Product Details -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <!-- Images -->
                    @if($product->images && count($product->images) > 0)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg mb-3">
                        </div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <div class="mt-4 space-y-3 border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">Price</p>
                                <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format($product->price, 0) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Category</p>
                                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($product->category) }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                    @if($product->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($product->status === 'pending') bg-orange-100 text-orange-800
                                    @elseif($product->status === 'published') bg-green-100 text-green-800
                                    @endif
                                ">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Stock</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    @if($product->is_unlimited_stock)
                                        Unlimited
                                    @else
                                        {{ $product->stock_quantity }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Description</h2>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>
                </div>

                <!-- Vendor Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Vendor Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-700"><span class="font-semibold">Name:</span> {{ $product->vendor->business_name }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ $product->vendor->email }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Phone:</span> {{ $product->vendor->phone }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Type:</span> {{ ucfirst($product->vendor->business_type) }}</p>
                        @if($product->vendor->is_certified)
                            <p class="text-green-600 mt-2">✓ Certified Vendor</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Moderation Panel -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Moderation</h2>

                    @if($product->status === 'pending')
                        <div class="space-y-3">
                            <!-- Approve -->
                            <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors">
                                    ✓ Approve
                                </button>
                            </form>

                            <!-- Reject -->
                            <form method="POST" action="{{ route('admin.products.reject', $product) }}" class="space-y-2">
                                @csrf
                                <textarea name="reason" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Rejection reason (optional)"></textarea>
                                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors">
                                    ✗ Reject
                                </button>
                            </form>
                        </div>
                    @elseif($product->status === 'published')
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <p class="text-sm text-green-800">✓ Approved by {{ $product->approvedBy->full_name }}</p>
                            <p class="text-xs text-green-700 mt-1">{{ $product->approved_at->format('d M Y H:i') }}</p>
                        </div>

                        <!-- Delete -->
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="mt-4" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-semibold transition-colors">
                                Delete Product
                            </button>
                        </form>
                    @endif

                    <!-- Stats -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3">Stats</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-700">Views: <span class="font-semibold">{{ $product->views_count }}</span></p>
                            <p class="text-gray-700">Sales: <span class="font-semibold">{{ $product->sales_count }}</span></p>
                            @if($product->rating)
                                <p class="text-gray-700">Rating: <span class="font-semibold">⭐ {{ $product->rating }}</span></p>
                            @endif
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-2 text-xs text-gray-600">
                        <p>Created: {{ $product->created_at->format('d M Y H:i') }}</p>
                        <p>Updated: {{ $product->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
