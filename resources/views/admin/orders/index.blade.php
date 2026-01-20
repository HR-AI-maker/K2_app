@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">All Orders</h1>

        @if($orders->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Order ID</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Customer</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Date</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Total</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Payment</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-blue-600 hover:text-blue-800">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $order->user->full_name }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rs. {{ number_format($order->total, 0) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'payment_pending') bg-orange-100 text-orange-800
                                        @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($order->payment_verified_at)
                                        <span class="text-green-600 text-sm">✓ Verified</span>
                                    @else
                                        <span class="text-orange-600 text-sm">⏳ Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">No orders</p>
            </div>
        @endif
    </div>
</div>
@endsection
