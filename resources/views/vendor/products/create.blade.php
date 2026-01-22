@extends('layouts.vendor')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Add New Product</h1>

        <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8">
            @csrf

            <!-- Product Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name*</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name') }}" placeholder="Enter product name">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category*</label>
                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                    <option value="">Select a category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
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
                <input type="number" name="price" required step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror" value="{{ old('price') }}" placeholder="0">
                @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock Options -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Management</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_unlimited_stock" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" {{ old('is_unlimited_stock') ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">This is a service with unlimited availability</span>
                    </label>

                    <div id="stockField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input type="number" name="stock_quantity" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror" value="{{ old('stock_quantity', 0) }}" placeholder="0">
                        @error('stock_quantity')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" placeholder="Describe your product or service">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Images -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images.*') border-red-500 @enderror">
                <p class="text-gray-600 text-xs mt-1">You can upload up to 5 images. Max 5MB per image.</p>
                @error('images.*')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                    Create Product
                </button>
                <a href="{{ route('vendor.products.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold transition-colors">
                    Cancel
                </a>
            </div>
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
