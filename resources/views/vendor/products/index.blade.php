@extends('layouts.vendor')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Products</h1>
            <a href="{{ route('vendor.products.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add Product
            </a>
        </div>

        @if($products->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Category</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Price</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Stock</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Views / Sales</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($product->images && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ ucfirst($product->category) }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rs. {{ number_format($product->price, 0) }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->is_unlimited_stock)
                                        <span class="text-green-600">Unlimited</span>
                                    @else
                                        <span class="text-gray-600">{{ $product->stock_quantity }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($product->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($product->status === 'pending') bg-orange-100 text-orange-800
                                        @elseif($product->status === 'published') bg-green-100 text-green-800
                                        @elseif($product->status === 'out_of_stock') bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ $product->views_count }} / {{ $product->sales_count }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('vendor.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-4">Edit</a>
                                    <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg mb-6">No products yet</p>
                <a href="{{ route('vendor.products.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
