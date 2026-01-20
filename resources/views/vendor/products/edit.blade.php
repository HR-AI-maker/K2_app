@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('vendor.products.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Products</a>

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Product</h1>

        <form method="POST" action="{{ route('vendor.products.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8">
            @csrf
            @method('PATCH')

            <!-- Status -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-700"><span class="font-medium">Current Status:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium mt-2
                        @if($product->status === 'draft') bg-gray-100 text-gray-800
                        @elseif($product->status === 'pending') bg-orange-100 text-orange-800
                        @elseif($product->status === 'published') bg-green-100 text-green-800
                        @endif
                    ">
                        {{ ucfirst($product->status) }}
                    </span>
                </p>
                @if($product->status === 'draft')
                    <p class="text-xs text-gray-600 mt-3">Save your changes and click "Submit for Approval" to request review.</p>
                @endif
            </div>

            <!-- Product Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name*</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name', $product->name) }}">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category*</label>
                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rs.)*</label>
                <input type="number" name="price" required step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror" value="{{ old('price', $product->price) }}">
                @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock Options -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Management</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_unlimited_stock" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" {{ old('is_unlimited_stock', $product->is_unlimited_stock) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">This is a service with unlimited availability</span>
                    </label>

                    <div id="stockField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input type="number" name="stock_quantity" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                        @error('stock_quantity')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Images -->
            @if($product->images && count($product->images) > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" alt="Product image" class="w-full h-24 object-cover rounded">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add More Images -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Add More Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images.*') border-red-500 @enderror">
                <p class="text-gray-600 text-xs mt-1">Upload additional images. Max 5MB per image.</p>
                @error('images.*')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                    Save Changes
                </button>
                <a href="{{ route('vendor.products.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold transition-colors">
                    Cancel
                </a>
            </div>

            <!-- Submit for Approval (Draft only) -->
            @if($product->status === 'draft')
                <form method="POST" action="{{ route('vendor.products.update', $product) }}" class="mt-6 pt-6 border-t border-gray-200">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="submit_approval" value="1" class="w-full px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold transition-colors">
                        Submit for Approval
                    </button>
                </form>
            @endif
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="is_unlimited_stock"]').addEventListener('change', function() {
    document.getElementById('stockField').style.display = this.checked ? 'none' : 'block';
});

// Initialize on page load
window.addEventListener('load', function() {
    const isUnlimited = document.querySelector('input[name="is_unlimited_stock"]').checked;
    document.getElementById('stockField').style.display = isUnlimited ? 'none' : 'block';
});
</script>
@endsection
