
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Products</h1>
            <a href="<?php echo e(route('vendor.products.create')); ?>" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add Product
            </a>
        </div>

        <?php if($products->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-900">Category</th>
                            <th class="text-right px-6 py-3 font-semibold text-gray-900">Price</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Stock</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Status</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Views / Sales</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?php if($product->images && count($product->images) > 0): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-10 h-10 object-cover rounded">
                                        <?php else: ?>
                                            <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                        <?php endif; ?>
                                        <span class="font-medium text-gray-900"><?php echo e($product->name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e(ucfirst($product->category)); ?></td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rs. <?php echo e(number_format($product->price, 0)); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <?php if($product->is_unlimited_stock): ?>
                                        <span class="text-green-600">Unlimited</span>
                                    <?php else: ?>
                                        <span class="text-gray-600"><?php echo e($product->stock_quantity); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        <?php if($product->status === 'draft'): ?> bg-gray-100 text-gray-800
                                        <?php elseif($product->status === 'pending'): ?> bg-orange-100 text-orange-800
                                        <?php elseif($product->status === 'published'): ?> bg-green-100 text-green-800
                                        <?php elseif($product->status === 'out_of_stock'): ?> bg-red-100 text-red-800
                                        <?php endif; ?>
                                    ">
                                        <?php echo e(ucfirst($product->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600">
                                    <?php echo e($product->views_count); ?> / <?php echo e($product->sales_count); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?php echo e(route('vendor.products.edit', $product)); ?>" class="text-blue-600 hover:text-blue-800 mr-4">Edit</a>
                                    <form method="POST" action="<?php echo e(route('vendor.products.destroy', $product)); ?>" class="inline" onsubmit="return confirm('Are you sure?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($products->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg mb-6">No products yet</p>
                <a href="<?php echo e(route('vendor.products.create')); ?>" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Add Your First Product
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/vendor/products/index.blade.php ENDPATH**/ ?>