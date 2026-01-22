<?php $__env->startSection('title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Order Management</h1>
        <p class="text-gray-600 mt-2">Track and manage marketplace orders</p>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'payment_pending' ? 'ring-2 ring-orange-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Payment Pending</p>
        <p class="text-2xl font-bold text-orange-600"><?php echo e($stats['payment_pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'paid' ? 'ring-2 ring-blue-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Paid</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['paid']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" <?php echo e($currentStatus === 'all' ? 'selected' : ''); ?>>All Statuses</option>
                    <option value="pending" <?php echo e($currentStatus === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="payment_pending" <?php echo e($currentStatus === 'payment_pending' ? 'selected' : ''); ?>>Payment Pending</option>
                    <option value="paid" <?php echo e($currentStatus === 'paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="processing" <?php echo e($currentStatus === 'processing' ? 'selected' : ''); ?>>Processing</option>
                    <option value="shipped" <?php echo e($currentStatus === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                    <option value="delivered" <?php echo e($currentStatus === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    <option value="cancelled" <?php echo e($currentStatus === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    <option value="refunded" <?php echo e($currentStatus === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment</label>
                <select name="payment" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" <?php echo e($currentPayment === 'all' ? 'selected' : ''); ?>>All</option>
                    <option value="verified" <?php echo e($currentPayment === 'verified' ? 'selected' : ''); ?>>Verified</option>
                    <option value="pending" <?php echo e($currentPayment === 'pending' ? 'selected' : ''); ?>>Pending</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Order, customer, email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                    <option value="total" <?php echo e(request('sort_by') === 'total' ? 'selected' : ''); ?>>Total</option>
                    <option value="status" <?php echo e(request('sort_by') === 'status' ? 'selected' : ''); ?>>Status</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <select name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="desc" <?php echo e(request('sort_order', 'desc') === 'desc' ? 'selected' : ''); ?>>Descending</option>
                    <option value="asc" <?php echo e(request('sort_order') === 'asc' ? 'selected' : ''); ?>>Ascending</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if($orders->count() > 0): ?>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Order</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Customer</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Total</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Payment</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-semibold text-blue-600 hover:text-blue-800">
                                <?php echo e($order->order_number); ?>

                            </a>
                            <p class="text-xs text-gray-500">#<?php echo e($order->id); ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-semibold"><?php echo e($order->user->full_name); ?></p>
                            <p class="text-gray-600"><?php echo e($order->user->email); ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($order->status === 'pending'): ?>
                                <span class="badge bg-yellow-100 text-yellow-800">Pending</span>
                            <?php elseif($order->status === 'payment_pending'): ?>
                                <span class="badge bg-orange-100 text-orange-800">Payment Pending</span>
                            <?php elseif($order->status === 'paid'): ?>
                                <span class="badge bg-blue-100 text-blue-800">Paid</span>
                            <?php elseif($order->status === 'processing'): ?>
                                <span class="badge bg-purple-100 text-purple-800">Processing</span>
                            <?php elseif($order->status === 'shipped'): ?>
                                <span class="badge bg-blue-100 text-blue-800">Shipped</span>
                            <?php elseif($order->status === 'delivered'): ?>
                                <span class="badge bg-green-100 text-green-800">Delivered</span>
                            <?php elseif($order->status === 'cancelled'): ?>
                                <span class="badge bg-red-100 text-red-800">Cancelled</span>
                            <?php elseif($order->status === 'refunded'): ?>
                                <span class="badge bg-gray-100 text-gray-800">Refunded</span>
                            <?php else: ?>
                                <span class="badge bg-gray-100 text-gray-800"><?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">
                            <?php echo e($order->created_at->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                            Rs. <?php echo e(number_format($order->total, 0)); ?>

                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <?php if($order->payment_verified_at): ?>
                                <span class="text-green-700 font-semibold">Verified</span>
                            <?php else: ?>
                                <span class="text-orange-700 font-semibold">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-blue-600 hover:text-blue-800 block">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No orders found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see more results</p>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>