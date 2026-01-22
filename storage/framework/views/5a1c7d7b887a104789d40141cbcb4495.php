
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Orders</h1>

        <?php if($orders->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Order ID</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Customer</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Date</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Items</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Amount</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="<?php echo e(route('vendor.orders.show', $order)); ?>" class="font-semibold text-blue-600 hover:text-blue-800">
                                        <?php echo e($order->order_number); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-700"><?php echo e($order->user->full_name); ?></td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e($order->created_at->format('d M Y')); ?></td>
                                <td class="px-6 py-4 text-center text-gray-700">
                                    <?php echo e($order->items->count()); ?>

                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                    Rs. <?php echo e(number_format($order->items->sum('total_price'), 0)); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        <?php if($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($order->status === 'payment_pending'): ?> bg-orange-100 text-orange-800
                                        <?php elseif($order->status === 'paid'): ?> bg-blue-100 text-blue-800
                                        <?php endif; ?>
                                    ">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?php echo e(route('vendor.orders.show', $order)); ?>" class="text-blue-600 hover:text-blue-800">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">No orders yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/vendor/orders/index.blade.php ENDPATH**/ ?>