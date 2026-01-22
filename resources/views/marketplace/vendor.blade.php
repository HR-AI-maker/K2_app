@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('marketplace.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Marketplace</a>

        <!-- Vendor Info -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $vendor->business_name }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <p class="text-gray-600"><span class="font-semibold">Type:</span> {{ ucfirst($vendor->business_type) }}</p>
                    <p class="text-gray-600 mt-2"><span class="font-semibold">Contact:</span> {{ $vendor->email }}</p>
                    <p class="text-gray-600 mt-2"><span class="font-semibold">Phone:</span> {{ $vendor->phone }}</p>
                    <p class="text-gray-600 mt-2"><span class="font-semibold">Location:</span> {{ $vendor->address }}</p>

                    @if($vendor->is_certified)
                        <p class="text-green-600 mt-2">✓ Certified Vendor</p>
                    @endif

                    @if($vendor->rating)
                        <p class="text-gray-600 mt-2"><span class="font-semibold">Rating:</span> ⭐ {{ number_format($vendor->rating, 1) }}/5</p>
                    @endif
                </div>

                <div>
                    <p class="text-gray-600"><span class="font-semibold">Description:</span></p>
                    <p class="text-gray-700 mt-2">{{ $vendor->description ?? 'No description available' }}</p>
                </div>
            </div>
        </div>

        <!-- Products -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Products & Services</h2>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    @include('marketplace.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg">
                <p class="text-gray-500 text-lg">No products available yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
