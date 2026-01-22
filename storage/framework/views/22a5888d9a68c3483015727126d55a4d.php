

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        <?php if($cartItems->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Cart Items -->
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Price</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Quantity</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Total</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <?php if($item->product->images && count($item->product->images) > 0): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->product->images[0])); ?>" alt="<?php echo e($item->product->name); ?>" class="w-16 h-16 object-cover rounded">
                                        <?php else: ?>
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                                <span class="text-xs">No image</span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?php echo e(route('marketplace.product.show', $item->product)); ?>" class="font-semibold text-gray-900 hover:text-blue-600">
                                                <?php echo e($item->product->name); ?>

                                            </a>
                                            <p class="text-sm text-gray-600"><?php echo e($item->product->vendor->business_name); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center px-6 py-4">Rs. <?php echo e(number_format($item->price_snapshot, 0)); ?></td>
                                <td class="text-center px-6 py-4">
                                    <form method="POST" action="<?php echo e(route('cart.update', $item)); ?>" class="inline-flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded">
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Update</button>
                                    </form>
                                </td>
                                <td class="text-right px-6 py-4 font-semibold">Rs. <?php echo e(number_format($item->subtotal, 0)); ?></td>
                                <td class="text-center px-6 py-4">
                                    <form method="POST" action="<?php echo e(route('cart.remove', $item)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Cart Summary -->
                <div class="px-6 py-8 bg-gray-50 border-t border-gray-200">
                    <div class="max-w-sm ml-auto space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rs. <?php echo e(number_format($total, 0)); ?></span>
                        </div>
                        <div class="border-t border-gray-300"></div>
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-gray-900">Estimated Total</span>
                            <span class="text-blue-600">Rs. <?php echo e(number_format($total, 0)); ?></span>
                        </div>
                        <p class="text-xs text-gray-600">Tax and shipping calculated at checkout</p>

                        <a href="<?php echo e(route('cart.checkout')); ?>" class="block w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-semibold mt-6 transition-colors">
                            Proceed to Checkout
                        </a>
                        <a href="<?php echo e(route('marketplace.index')); ?>" class="block w-full px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center font-semibold transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg mb-6">Your cart is empty</p>
                <a href="<?php echo e(route('marketplace.index')); ?>" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/cart/index.blade.php ENDPATH**/ ?>