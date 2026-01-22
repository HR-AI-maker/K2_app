@extends('layouts.vendor')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('vendor.orders.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Orders</a>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-600">Order Number</p>
                    <p class="text-xl font-bold text-gray-900">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Customer</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $order->user->full_name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Order Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Your Items in This Order -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Your Items</h2>

            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 last:border-0 last:pb-0">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-600">
                                Fulfillment Status:
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                    @if($item->fulfillment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($item->fulfillment_status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($item->fulfillment_status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($item->fulfillment_status === 'delivered') bg-green-100 text-green-800
                                    @endif
                                ">
                                    {{ ucfirst($item->fulfillment_status) }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">Rs. {{ number_format($item->total_price, 0) }}</p>
                            <p class="text-sm text-gray-600">Rs. {{ number_format($item->unit_price, 0) }} each</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Customer Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Customer Information</h2>
                <p class="text-gray-700"><span class="font-semibold">Name:</span> {{ $order->user->full_name }}</p>
                <p class="text-gray-700 mt-2"><span class="font-semibold">Email:</span> {{ $order->user->email }}</p>
                <p class="text-gray-700 mt-2"><span class="font-semibold">Phone:</span> {{ $order->user->phone }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Shipping Address</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $order->shipping_address }}</p>
                <p class="text-gray-600 mt-3">Phone: {{ $order->shipping_phone }}</p>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Order Status</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-700">Overall Status</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'payment_pending') bg-orange-100 text-orange-800
                        @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @endif
                    ">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>

                @if($order->payment_verified_at)
                    <div class="text-sm text-green-600">✓ Payment verified on {{ $order->payment_verified_at->format('d M Y') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
