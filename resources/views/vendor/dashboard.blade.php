@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Vendor Dashboard</h1>
            <p class="text-gray-600 mt-2">{{ $vendor->business_name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Products</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="text-4xl text-blue-600">📦</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pending Approval</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_approval'] }}</p>
                    </div>
                    <div class="text-4xl text-orange-600">⏳</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Sales</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['total_sales'] }}</p>
                    </div>
                    <div class="text-4xl text-green-600">✓</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Views</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_views'] }}</p>
                    </div>
                    <div class="text-4xl text-purple-600">👁️</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('vendor.products.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Add New Product
                </a>
                <a href="{{ route('vendor.products.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Manage Products
                </a>
                <a href="{{ route('vendor.orders.index') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    View Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pending Orders -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">Pending Orders</h2>
                </div>
                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($orders as $orderItem)
                            <div class="p-4 hover:bg-gray-50">
                                <a href="{{ route('vendor.orders.show', $orderItem->order) }}" class="block">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $orderItem->order->order_number }}</p>
                                            <p class="text-sm text-gray-600">{{ $orderItem->product_name }}</p>
                                        </div>
                                        <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                            @if($orderItem->fulfillment_status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($orderItem->fulfillment_status === 'processing') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            {{ ucfirst($orderItem->fulfillment_status) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Qty: {{ $orderItem->quantity }} | Total: Rs. {{ number_format($orderItem->total_price, 0) }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        No pending orders
                    </div>
                @endif
            </div>

            <!-- Recent Products -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">Recent Products</h2>
                </div>
                @if($recentProducts->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($recentProducts as $product)
                            <div class="p-4 hover:bg-gray-50">
                                <a href="{{ route('vendor.products.edit', $product) }}" class="block">
                                    <p class="font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">Rs. {{ number_format($product->price, 0) }}</p>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-xs px-2 py-1 rounded
                                            @if($product->status === 'draft') bg-gray-100 text-gray-700
                                            @elseif($product->status === 'pending') bg-orange-100 text-orange-700
                                            @elseif($product->status === 'published') bg-green-100 text-green-700
                                            @endif
                                        ">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $product->views_count }} views</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        No products yet
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
