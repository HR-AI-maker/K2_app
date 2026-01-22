

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="<?php echo e(route('orders.index')); ?>" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Orders</a>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600">Order Number</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($order->order_number); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Order Date</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($order->created_at->format('d M Y \a\t H:i')); ?></p>
                </div>
            </div>

            <!-- Status -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-600 mb-2">Status</p>
                <span class="inline-block px-4 py-2 rounded-full text-sm font-medium
                    <?php if($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                    <?php elseif($order->status === 'payment_pending'): ?> bg-orange-100 text-orange-800
                    <?php elseif($order->status === 'paid'): ?> bg-blue-100 text-blue-800
                    <?php elseif($order->status === 'processing'): ?> bg-blue-100 text-blue-800
                    <?php elseif($order->status === 'shipped'): ?> bg-purple-100 text-purple-800
                    <?php elseif($order->status === 'delivered'): ?> bg-green-100 text-green-800
                    <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-800
                    <?php else: ?> bg-gray-100 text-gray-800
                    <?php endif; ?>
                ">
                    <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                </span>

                <?php if($order->payment_verified_at): ?>
                    <p class="text-sm text-green-600 mt-3">
                        ✓ Payment verified on <?php echo e($order->payment_verified_at->format('d M Y')); ?>

                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>

            <div class="space-y-4">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 last:border-0 last:pb-0">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900"><?php echo e($item->product_name); ?></h3>
                            <p class="text-sm text-gray-600">Vendor: <?php echo e($item->vendor->business_name); ?></p>
                            <p class="text-sm text-gray-600">
                                Fulfillment Status:
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                    <?php if($item->fulfillment_status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($item->fulfillment_status === 'processing'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($item->fulfillment_status === 'shipped'): ?> bg-purple-100 text-purple-800
                                    <?php elseif($item->fulfillment_status === 'delivered'): ?> bg-green-100 text-green-800
                                    <?php endif; ?>
                                ">
                                    <?php echo e(ucfirst($item->fulfillment_status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600"><?php echo e($item->quantity); ?> x Rs. <?php echo e(number_format($item->unit_price, 0)); ?></p>
                            <p class="text-lg font-semibold text-gray-900">Rs. <?php echo e(number_format($item->total_price, 0)); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Shipping Address</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($order->shipping_address); ?></p>
                <p class="text-gray-600 mt-3">Phone: <?php echo e($order->shipping_phone); ?></p>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rs. <?php echo e(number_format($order->subtotal, 0)); ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax</span>
                        <span>Rs. <?php echo e(number_format($order->tax, 0)); ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>Rs. <?php echo e(number_format($order->shipping_fee, 0)); ?></span>
                    </div>
                    <div class="border-t border-gray-300 pt-3 flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-blue-600">Rs. <?php echo e(number_format($order->total, 0)); ?></span>
                    </div>

                    <?php if($order->amount_paid > 0): ?>
                        <div class="border-t border-gray-300 pt-3 flex justify-between text-gray-700">
                            <span>Amount Paid</span>
                            <span>Rs. <?php echo e(number_format($order->amount_paid, 0)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Special Notes -->
        <?php if($order->notes): ?>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Special Notes</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($order->notes); ?></p>
            </div>
        <?php endif; ?>

        <!-- Actions -->
        <?php if(in_array($order->status, ['pending', 'payment_pending'])): ?>
            <form method="POST" action="<?php echo e(route('orders.cancel', $order)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Cancel Order
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/orders/show.blade.php ENDPATH**/ ?>