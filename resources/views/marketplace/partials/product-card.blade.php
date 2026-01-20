<a href="{{ route('marketplace.product.show', $product) }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
    <!-- Product Image -->
    <div class="relative w-full h-48 bg-gray-200">
        @if($product->images && count($product->images) > 0)
            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <span>No image</span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 truncate">{{ $product->name }}</h3>

        <!-- Vendor Name -->
        <p class="text-sm text-gray-600 mt-1">{{ $product->vendor->business_name }}</p>

        <!-- Category and Views -->
        <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
            <span class="inline-block bg-gray-100 px-2 py-1 rounded">{{ ucfirst($product->category) }}</span>
            <span>{{ $product->views_count }} views</span>
        </div>

        <!-- Price -->
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-lg font-bold text-blue-600">Rs. {{ number_format($product->price, 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">
                @if($product->is_unlimited_stock)
                    In Stock
                @elseif($product->stock_quantity > 0)
                    {{ $product->stock_quantity }} available
                @else
                    Out of Stock
                @endif
            </p>
        </div>

        <!-- Add to Cart Button -->
        @if(auth()->check() && $product->isAvailable())
            <button onclick="addToCart(event, {{ $product->id }})" class="w-full mt-3 px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                Add to Cart
            </button>
        @elseif(!auth()->check())
            <a href="{{ route('login') }}" class="block w-full mt-3 px-3 py-2 bg-gray-300 text-gray-700 text-sm rounded text-center">
                Sign in to Buy
            </a>
        @else
            <button disabled class="w-full mt-3 px-3 py-2 bg-gray-300 text-gray-500 text-sm rounded cursor-not-allowed">
                Out of Stock
            </button>
        @endif
    </div>
</a>
