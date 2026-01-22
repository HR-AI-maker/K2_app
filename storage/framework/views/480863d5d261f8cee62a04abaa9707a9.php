

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Product Moderation</h1>
            <p class="text-gray-600 mt-2">Review and approve vendor products</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex gap-4 mb-6 border-b border-gray-200" x-data="{ tab: 'pending' }">
            <button @click="tab = 'pending'" :class="tab === 'pending' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="pb-3 px-4 font-medium transition">
                📋 Pending (<?php echo e($pendingProducts->total()); ?>)
            </button>
            <button @click="tab = 'published'" :class="tab === 'published' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="pb-3 px-4 font-medium transition">
                ✅ Published (<?php echo e($publishedProducts->total()); ?>)
            </button>
            <button @click="tab = 'rejected'" :class="tab === 'rejected' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'" class="pb-3 px-4 font-medium transition">
                ❌ Rejected (<?php echo e($rejectedProducts->total()); ?>)
            </button>
        </div>

        <!-- Pending Products Tab -->
        <div x-show="tab === 'pending'" x-cloak class="space-y-4">
            <?php if($pendingProducts->count() > 0): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Vendor</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Price</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Date</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($product->images && count($product->images) > 0): ?>
                                                <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-12 h-12 object-cover rounded">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($product->name); ?></p>
                                                <p class="text-xs text-gray-500"><?php echo e(ucfirst($product->category)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700"><?php echo e($product->vendor->business_name); ?></td>
                                    <td class="px-6 py-4 text-center text-gray-900 font-medium">Rs. <?php echo e(number_format($product->price, 0)); ?></td>
                                    <td class="px-6 py-4 text-center text-gray-600"><?php echo e($product->created_at->format('d M Y')); ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 text-sm font-medium">
                                                Review
                                            </a>
                                            <form action="<?php echo e(route('admin.products.approve', $product)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="px-3 py-1 bg-green-100 text-green-600 rounded hover:bg-green-200 text-sm font-medium">
                                                    ✅ Approve
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($pendingProducts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg">✅ No pending products - all products have been reviewed!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Published Products Tab -->
        <div x-show="tab === 'published'" x-cloak class="space-y-4">
            <?php if($publishedProducts->count() > 0): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Vendor</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Price</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Approved</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $publishedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($product->images && count($product->images) > 0): ?>
                                                <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-12 h-12 object-cover rounded">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($product->name); ?></p>
                                                <p class="text-xs text-gray-500"><?php echo e(ucfirst($product->category)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700"><?php echo e($product->vendor->business_name); ?></td>
                                    <td class="px-6 py-4 text-center text-gray-900 font-medium">Rs. <?php echo e(number_format($product->price, 0)); ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            <?php echo e($product->approved_at?->format('d M Y')); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 text-sm font-medium">
                                                View
                                            </a>
                                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($publishedProducts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg">No published products yet</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Rejected Products Tab -->
        <div x-show="tab === 'rejected'" x-cloak class="space-y-4">
            <?php if($rejectedProducts->count() > 0): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Product</th>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Vendor</th>
                                <th class="text-left px-6 py-3 font-semibold text-gray-900">Rejection Reason</th>
                                <th class="text-center px-6 py-3 font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rejectedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($product->images && count($product->images) > 0): ?>
                                                <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-12 h-12 object-cover rounded">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($product->name); ?></p>
                                                <p class="text-xs text-gray-500">Rs. <?php echo e(number_format($product->price, 0)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700"><?php echo e($product->vendor->business_name); ?></td>
                                    <td class="px-6 py-4 text-gray-700 text-sm">
                                        <div class="max-w-xs"><?php echo e($product->rejection_reason ?? 'No reason provided'); ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 text-sm font-medium">
                                                Review
                                            </a>
                                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($rejectedProducts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg">No rejected products</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Alpine.js script for tabs (if not already included) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/products/index.blade.php ENDPATH**/ ?>