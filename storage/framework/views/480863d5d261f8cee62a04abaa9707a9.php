<?php $__env->startSection('title', 'Product Moderation'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Product Moderation</h1>
        <p class="text-gray-600 mt-2">Review and approve vendor products</p>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'published' ? 'ring-2 ring-green-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['published']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'rejected' ? 'ring-2 ring-red-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Rejected</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['rejected']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" <?php echo e($currentStatus === 'all' ? 'selected' : ''); ?>>All Products</option>
                    <option value="pending" <?php echo e($currentStatus === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="published" <?php echo e($currentStatus === 'published' ? 'selected' : ''); ?>>Published</option>
                    <option value="rejected" <?php echo e($currentStatus === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Categories</option>
                    <option value="equipment" <?php echo e($currentCategory === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                    <option value="clothing" <?php echo e($currentCategory === 'clothing' ? 'selected' : ''); ?>>Clothing</option>
                    <option value="guides" <?php echo e($currentCategory === 'guides' ? 'selected' : ''); ?>>Guides</option>
                    <option value="transport" <?php echo e($currentCategory === 'transport' ? 'selected' : ''); ?>>Transport</option>
                    <option value="lodging" <?php echo e($currentCategory === 'lodging' ? 'selected' : ''); ?>>Lodging</option>
                    <option value="food" <?php echo e($currentCategory === 'food' ? 'selected' : ''); ?>>Food</option>
                    <option value="other" <?php echo e($currentCategory === 'other' ? 'selected' : ''); ?>>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Product or vendor name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                    <option value="price" <?php echo e(request('sort_by') === 'price' ? 'selected' : ''); ?>>Price</option>
                    <option value="sales_count" <?php echo e(request('sort_by') === 'sales_count' ? 'selected' : ''); ?>>Top Selling</option>
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

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if($products->count() > 0): ?>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Vendor</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Price</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Stock</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <?php if($product->images && count($product->images) > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="w-12 h-12 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">📦</div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold"><?php echo e($product->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(ucfirst($product->category)); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-semibold"><?php echo e($product->vendor->business_name); ?></p>
                            <p class="text-gray-600"><?php echo e($product->vendor->email); ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($product->status === 'pending'): ?>
                                <span class="badge bg-yellow-100 text-yellow-800">Pending</span>
                            <?php elseif($product->status === 'published'): ?>
                                <span class="badge bg-green-100 text-green-800">Published</span>
                            <?php elseif($product->status === 'rejected'): ?>
                                <span class="badge bg-red-100 text-red-800">Rejected</span>
                            <?php else: ?>
                                <span class="badge bg-gray-100 text-gray-800"><?php echo e(ucfirst($product->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            Rs. <?php echo e(number_format($product->price, 0)); ?>

                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <?php if($product->is_unlimited_stock): ?>
                                <span class="text-green-700 font-semibold">Unlimited</span>
                            <?php else: ?>
                                <?php echo e($product->stock_quantity ?? 0); ?>

                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="text-blue-600 hover:text-blue-800 block">
                                View
                            </a>
                            <?php if($product->status === 'pending' || $product->status === 'rejected'): ?>
                                <form action="<?php echo e(route('admin.products.approve', $product)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full">
                                        Approve
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-800 block w-full">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No products found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see more results</p>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($products->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/products/index.blade.php ENDPATH**/ ?>