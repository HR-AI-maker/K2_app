@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Product Moderation</h1>

        @if($products->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Vendor</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Date</th>
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
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">Rs. {{ number_format($product->price, 0) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $product->vendor->business_name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($product->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($product->status === 'pending') bg-orange-100 text-orange-800
                                        @elseif($product->status === 'published') bg-green-100 text-green-800
                                        @endif
                                    ">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    {{ $product->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">No products to moderate</p>
            </div>
        @endif
    </div>
</div>
@endsection
