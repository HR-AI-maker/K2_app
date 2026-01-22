

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

        <?php if($orders->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Order ID</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Date</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Items</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Total</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="font-semibold text-blue-600 hover:text-blue-800">
                                        <?php echo e($order->order_number); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($order->created_at->format('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($order->items->count()); ?> <?php echo e($order->items->count() === 1 ? 'item' : 'items'); ?>

                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                    Rs. <?php echo e(number_format($order->total, 0)); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
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
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg mb-6">You haven't placed any orders yet</p>
                <a href="<?php echo e(route('marketplace.index')); ?>" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/orders/index.blade.php ENDPATH**/ ?>