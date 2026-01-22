@extends('layouts.member')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="md:col-span-2">
                <form method="POST" action="{{ route('cart.processCheckout') }}" class="space-y-6">
                    @csrf

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Address</label>
                                <textarea name="shipping_address" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_address') border-red-500 @enderror" placeholder="Enter your complete shipping address">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="shipping_phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_phone') border-red-500 @enderror" placeholder="Your phone number" value="{{ old('shipping_phone') }}">
                                @error('shipping_phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Special Notes (Optional)</label>
                                <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Any special instructions for delivery">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>

                        <div class="space-y-3 border-b border-gray-200 pb-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                    <span>Rs. {{ number_format($item->subtotal, 0) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span>Rs. {{ number_format($total, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Tax (5%)</span>
                                <span>Rs. {{ number_format($totals['tax'], 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Shipping</span>
                                <span>{{ $totals['shipping_fee'] > 0 ? 'Rs. ' . number_format($totals['shipping_fee'], 0) : 'Free' }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                                <span>Total</span>
                                <span class="text-blue-600">Rs. {{ number_format($totals['total'], 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-semibold transition-colors">
                        Place Order
                    </button>
                    <a href="{{ route('cart.index') }}" class="block w-full px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center font-semibold transition-colors">
                        Back to Cart
                    </a>
                </form>
            </div>

            <!-- Order Items Preview -->
            <div class="bg-white rounded-lg shadow p-6 h-fit">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Items</h2>
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex gap-3 pb-4 border-b border-gray-200 last:border-0 last:pb-0">
                            @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                                    No img
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                                <p class="text-sm font-semibold text-blue-600 mt-1">Rs. {{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

