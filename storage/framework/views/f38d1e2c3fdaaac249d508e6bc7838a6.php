<?php $__env->startSection('title', 'Vendor Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">🏪 Vendor Directory</h1>
            <p class="text-gray-600 mt-2">Manage guides, transportation, lodging, and equipment vendors</p>
        </div>
        <a href="<?php echo e(route('admin.vendors.create')); ?>" class="btn-primary">
            ➕ Add Vendor
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'verified' ? 'ring-2 ring-green-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Verified</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['verified']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'suspended' ? 'ring-2 ring-red-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Suspended</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['suspended']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.vendors.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="all" <?php echo e($currentStatus === 'all' ? 'selected' : ''); ?>>All Vendors</option>
                    <option value="pending" <?php echo e($currentStatus === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="verified" <?php echo e($currentStatus === 'verified' ? 'selected' : ''); ?>>Verified</option>
                    <option value="suspended" <?php echo e($currentStatus === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                </select>
            </div>

            <!-- Business Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="business_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="guide" <?php echo e($currentBusinessType === 'guide' ? 'selected' : ''); ?>>Guide</option>
                    <option value="transport" <?php echo e($currentBusinessType === 'transport' ? 'selected' : ''); ?>>Transport</option>
                    <option value="lodging" <?php echo e($currentBusinessType === 'lodging' ? 'selected' : ''); ?>>Lodging</option>
                    <option value="equipment" <?php echo e($currentBusinessType === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                    <option value="other" <?php echo e($currentBusinessType === 'other' ? 'selected' : ''); ?>>Other</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Business name, contact..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                    <option value="verified_at" <?php echo e(request('sort_by') === 'verified_at' ? 'selected' : ''); ?>>Recently Verified</option>
                    <option value="rating" <?php echo e(request('sort_by') === 'rating' ? 'selected' : ''); ?>>Highest Rated</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Vendors Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if($vendors->count() > 0): ?>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Business Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Contact</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Rating</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold"><?php echo e($vendor->business_name); ?></p>
                                <?php if($vendor->is_certified): ?>
                                    <p class="text-xs text-yellow-600">⭐ Certified</p>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="badge
                                <?php if($vendor->business_type === 'guide'): ?> bg-blue-100 text-blue-800
                                <?php elseif($vendor->business_type === 'transport'): ?> bg-purple-100 text-purple-800
                                <?php elseif($vendor->business_type === 'lodging'): ?> bg-orange-100 text-orange-800
                                <?php elseif($vendor->business_type === 'equipment'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($vendor->business_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-semibold"><?php echo e($vendor->contact_person); ?></p>
                            <p class="text-gray-600"><?php echo e($vendor->email); ?></p>
                            <p class="text-gray-600"><?php echo e($vendor->phone); ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($vendor->status === 'pending'): ?>
                                <span class="badge bg-yellow-100 text-yellow-800">⏳ Pending</span>
                            <?php elseif($vendor->status === 'verified'): ?>
                                <span class="badge bg-green-100 text-green-800">✓ Verified</span>
                            <?php elseif($vendor->status === 'suspended'): ?>
                                <span class="badge bg-red-100 text-red-800">✗ Suspended</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($vendor->rating): ?>
                                <div class="flex items-center gap-1">
                                    <?php for($i = 0; $i < 5; $i++): ?>
                                        <?php if($i < floor($vendor->rating)): ?>
                                            <span class="text-yellow-400">★</span>
                                        <?php else: ?>
                                            <span class="text-gray-300">☆</span>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-xs"><?php echo e(number_format($vendor->rating, 1)); ?> / 5.0</p>
                            <?php else: ?>
                                <span class="text-gray-500">No rating</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="text-blue-600 hover:text-blue-800 block">
                                View
                            </a>
                            <a href="<?php echo e(route('admin.vendors.edit', $vendor)); ?>" class="text-blue-600 hover:text-blue-800 block">
                                Edit
                            </a>
                            <?php if($vendor->status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('admin.vendors.verify', $vendor)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full">
                                        Verify
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if($vendor->status === 'verified'): ?>
                                <form method="POST" action="<?php echo e(route('admin.vendors.suspend', $vendor)); ?>" class="inline" onsubmit="return confirm('Suspend this vendor?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 block w-full">
                                        Suspend
                                    </button>
                                </form>
                            <?php elseif($vendor->status === 'suspended'): ?>
                                <form method="POST" action="<?php echo e(route('admin.vendors.reactivate', $vendor)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 block w-full">
                                        Reactivate
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('admin.vendors.destroy', $vendor)); ?>" class="inline" onsubmit="return confirm('Delete this vendor?');">
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
            <p class="text-gray-600 text-lg">No vendors found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters or create a new vendor</p>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($vendors->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/vendors/index.blade.php ENDPATH**/ ?>