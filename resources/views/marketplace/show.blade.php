@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('marketplace.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Marketplace</a>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div>
                    @if($product->images && count($product->images) > 0)
                        <div class="bg-gray-200 rounded-lg overflow-hidden h-96 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                        @if(count($product->images) > 1)
                            <div class="grid grid-cols-4 gap-2 mt-4">
                                @foreach($product->images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="h-20 rounded cursor-pointer hover:opacity-80 transition-opacity object-cover">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-300 rounded-lg h-96 flex items-center justify-center text-gray-600">
                            <span>No images available</span>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <!-- Vendor Info -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <a href="{{ route('marketplace.vendor', $product->vendor) }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                            {{ $product->vendor->business_name }}
                        </a>
                        @if($product->vendor->is_certified)
                            <p class="text-sm text-green-600 mt-1">✓ Certified Vendor</p>
                        @endif
                    </div>

                    <!-- Category and Stats -->
                    <div class="mt-4 flex gap-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ ucfirst($product->category) }}</span>
                        <span class="text-gray-600 text-sm">{{ $product->views_count }} views</span>
                        <span class="text-gray-600 text-sm">{{ $product->sales_count }} sold</span>
                    </div>

                    <!-- Price -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-4xl font-bold text-blue-600">Rs. {{ number_format($product->price, 0) }}</p>
                    </div>

                    <!-- Stock Status -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        @if($product->is_unlimited_stock)
                            <p class="text-green-600 font-semibold">✓ Always in Stock</p>
                        @elseif($product->stock_quantity > 0)
                            <p class="text-green-600 font-semibold">✓ {{ $product->stock_quantity }} available</p>
                        @else
                            <p class="text-red-600 font-semibold">✗ Out of Stock</p>
                        @endif
                    </div>

                    <!-- Add to Cart -->
                    @if(auth()->check() && $product->isAvailable())
                        <div class="mt-6">
                            <form id="addToCartForm" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" class="w-20 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="button" onclick="addToCart(event, {{ $product->id }})" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-semibold transition-colors">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    @elseif(!auth()->check())
                        <a href="{{ route('login') }}" class="block w-full mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center text-lg font-semibold transition-colors">
                            Sign in to Purchase
                        </a>
                    @else
                        <button disabled class="w-full mt-6 px-6 py-3 bg-gray-300 text-gray-500 rounded-lg text-lg font-semibold cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $product->description ?? 'No description available' }}</p>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(event, productId) {
    event.preventDefault();
    const quantity = document.getElementById('quantity')?.value || 1;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity),
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart!');
            window.location.href = '{{ route("cart.index") }}';
        } else {
            alert('Error adding to cart');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
