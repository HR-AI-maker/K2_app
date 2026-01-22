@extends('layouts.admin')

@section('title', 'Product Moderation')

@section('content')
<div class="mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Product Moderation</h1>
        <p class="text-gray-600 mt-2">Review and approve vendor products</p>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : '' }}">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'published' ? 'ring-2 ring-green-600' : '' }}">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'rejected' ? 'ring-2 ring-red-600' : '' }}">
        <p class="text-gray-600 text-sm">Rejected</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>All Products</option>
                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ $currentStatus === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Categories</option>
                    <option value="equipment" {{ $currentCategory === 'equipment' ? 'selected' : '' }}>Equipment</option>
                    <option value="clothing" {{ $currentCategory === 'clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="guides" {{ $currentCategory === 'guides' ? 'selected' : '' }}>Guides</option>
                    <option value="transport" {{ $currentCategory === 'transport' ? 'selected' : '' }}>Transport</option>
                    <option value="lodging" {{ $currentCategory === 'lodging' ? 'selected' : '' }}>Lodging</option>
                    <option value="food" {{ $currentCategory === 'food' ? 'selected' : '' }}>Food</option>
                    <option value="other" {{ $currentCategory === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Product or vendor name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Price</option>
                    <option value="sales_count" {{ request('sort_by') === 'sales_count' ? 'selected' : '' }}>Top Selling</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <select name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="desc" {{ request('sort_order', 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($products->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Vendor</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Price</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Stock</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($product->category) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-semibold">{{ $product->vendor->business_name }}</p>
                            <p class="text-gray-600">{{ $product->vendor->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($product->status === 'pending')
                                <span class="badge bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif ($product->status === 'published')
                                <span class="badge bg-green-100 text-green-800">Published</span>
                            @elseif ($product->status === 'rejected')
                                <span class="badge bg-red-100 text-red-800">Rejected</span>
                            @else
                                <span class="badge bg-gray-100 text-gray-800">{{ ucfirst($product->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            Rs. {{ number_format($product->price, 0) }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            @if ($product->is_unlimited_stock)
                                <span class="text-green-700 font-semibold">Unlimited</span>
                            @else
                                {{ $product->stock_quantity ?? 0 }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-800 block">
                                View
                            </a>
                            @if ($product->status === 'pending' || $product->status === 'rejected')
                                <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full">
                                        Approve
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
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
            <p class="text-gray-600 text-lg">No products found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see more results</p>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection
