@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back</a>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-600">Order Number</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Customer</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->user->full_name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items & Details -->
            <div class="lg:col-span-2">
                <!-- Items -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>

                    <div class="space-y-4 border-b border-gray-200 pb-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between pb-4 last:pb-0">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-600">Vendor: {{ $item->vendor->business_name }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rs. {{ number_format($item->total_price, 0) }}</p>
                                    <p class="text-xs text-gray-600">@ Rs. {{ number_format($item->unit_price, 0) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span>Rs. {{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Tax</span>
                            <span>Rs. {{ number_format($order->tax, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Shipping</span>
                            <span>Rs. {{ number_format($order->shipping_fee, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                            <span>Order Total</span>
                            <span class="text-blue-600">Rs. {{ number_format($order->total, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Shipping Address</h2>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $order->shipping_address }}</p>
                    <p class="text-gray-600 mt-3">Phone: {{ $order->shipping_phone }}</p>
                </div>
            </div>

            <!-- Payment & Status Panel -->
            <div>
                <!-- Payment Status -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Payment Status</h2>

                    <div class="mb-4 p-3 rounded-lg
                        @if($order->payment_verified_at) bg-green-50 border border-green-200
                        @else bg-orange-50 border border-orange-200
                        @endif
                    ">
                        @if($order->payment_verified_at)
                            <p class="text-sm font-semibold text-green-800">✓ Payment Verified</p>
                            <p class="text-xs text-green-700 mt-1">
                                Verified by: {{ $order->paymentVerifiedBy->full_name }}
                                <br>
                                Date: {{ $order->payment_verified_at->format('d M Y H:i') }}
                            </p>
                            <p class="text-xs text-green-700 mt-2">Amount: Rs. {{ number_format($order->amount_paid, 0) }}</p>
                        @else
                            <p class="text-sm font-semibold text-orange-800">⏳ Payment Not Verified</p>
                            <p class="text-xs text-orange-700 mt-1">Awaiting payment verification</p>
                        @endif
                    </div>

                    @if(!$order->payment_verified_at)
                        <form method="POST" action="{{ route('admin.orders.verifyPayment', $order) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid (Rs.)</label>
                                <input type="number" name="amount_paid" required step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ $order->amount_paid }}">
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors">
                                Verify Payment
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Order Status</h2>

                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="space-y-3">
                        @csrf
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="payment_pending" {{ $order->status === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                            Update Status
                        </button>
                    </form>

                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600">Current: <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
