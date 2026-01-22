<?php $__env->startSection('title', 'Vendor: ' . $vendor->business_name); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <a href="<?php echo e(route('admin.vendors.index')); ?>" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Vendors
    </a>
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900"><?php echo e($vendor->business_name); ?></h1>
            <div class="flex gap-2 mt-2">
                <?php if($vendor->status === 'pending'): ?>
                    <span class="badge bg-yellow-100 text-yellow-800">⏳ Pending</span>
                <?php elseif($vendor->status === 'verified'): ?>
                    <span class="badge bg-green-100 text-green-800">✓ Verified</span>
                <?php elseif($vendor->status === 'suspended'): ?>
                    <span class="badge bg-red-100 text-red-800">✗ Suspended</span>
                <?php endif; ?>
                <?php if($vendor->is_certified): ?>
                    <span class="badge bg-yellow-100 text-yellow-800">⭐ Certified</span>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo e(route('admin.vendors.edit', $vendor)); ?>" class="btn-primary">
            ✎ Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Business Information -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6">Business Information</h2>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Contact Person</p>
                    <p class="font-semibold"><?php echo e($vendor->contact_person); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Business Type</p>
                    <p class="font-semibold capitalize"><?php echo e($vendor->business_type); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Email</p>
                    <p class="font-semibold">
                        <a href="mailto:<?php echo e($vendor->email); ?>" class="text-blue-600 hover:underline">
                            <?php echo e($vendor->email); ?>

                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Phone</p>
                    <p class="font-semibold">
                        <a href="tel:<?php echo e($vendor->phone); ?>" class="text-blue-600 hover:underline">
                            <?php echo e($vendor->phone); ?>

                        </a>
                    </p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">📍 Location</p>
                <p class="font-semibold"><?php echo e($vendor->address); ?></p>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-4">Description</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo e($vendor->description); ?></p>
        </div>

        <!-- Certification -->
        <?php if($vendor->is_certified): ?>
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-4 text-yellow-900">⭐ Certification Details</h2>
                <p class="text-gray-700 leading-relaxed"><?php echo e($vendor->certification_details ?? 'Vendor is certified and verified.'); ?></p>
            </div>
        <?php endif; ?>

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status & Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Status & Actions</h3>

            <div class="space-y-2 mb-6 pb-6 border-b border-gray-200">
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="font-semibold capitalize"><?php echo e($vendor->status); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Bookings</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo e($vendor->total_bookings ?? 0); ?></p>
                </div>
            </div>

            <div class="space-y-2">
                <?php if($vendor->status === 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('admin.vendors.verify', $vendor)); ?>" class="block">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                            ✓ Verify Vendor
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($vendor->status === 'verified'): ?>
                    <form method="POST" action="<?php echo e(route('admin.vendors.suspend', $vendor)); ?>" class="block" onsubmit="return confirm('Suspend this vendor?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold">
                            ⚠️ Suspend Vendor
                        </button>
                    </form>
                <?php elseif($vendor->status === 'suspended'): ?>
                    <form method="POST" action="<?php echo e(route('admin.vendors.reactivate', $vendor)); ?>" class="block">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                            🔄 Reactivate
                        </button>
                    </form>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.vendors.destroy', $vendor)); ?>" class="block" onsubmit="return confirm('Delete this vendor?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        🗑️ Delete Vendor
                    </button>
                </form>
            </div>
        </div>

        <!-- Rating -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Rating</h3>

            <div class="text-center mb-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-center gap-1 mb-2">
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <?php if($i < floor($vendor->rating ?? 0)): ?>
                            <span class="text-3xl text-yellow-400">★</span>
                        <?php else: ?>
                            <span class="text-3xl text-gray-300">☆</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <p class="text-2xl font-bold"><?php echo e($vendor->rating ? number_format($vendor->rating, 1) : 'Unrated'); ?></p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.vendors.updateRating', $vendor)); ?>" class="space-y-2">
                <?php echo csrf_field(); ?>
                <label for="rating" class="block text-sm font-semibold text-gray-900">Update Rating (0-5)</label>
                <div class="flex gap-2">
                    <input
                        type="number"
                        id="rating"
                        name="rating"
                        value="<?php echo e($vendor->rating); ?>"
                        min="0"
                        max="5"
                        step="0.1"
                        class="input flex-1"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Vendor Login Credentials -->
        <?php if($vendor->status === 'verified'): ?>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 <?php if($vendor->vendor_user_id): ?> border-l-green-500 <?php else: ?> border-l-orange-500 <?php endif; ?>">
                <h3 class="text-lg font-bold mb-4">Login Credentials</h3>

                <?php if($vendor->vendor_user_id): ?>
                    <div class="bg-green-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-green-800">
                            ✓ <span class="font-semibold">Credentials Created</span>
                        </p>
                        <p class="text-xs text-green-700 mt-1">Vendor can now log in and manage their marketplace products</p>
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('admin.vendors.createCredentials', $vendor)); ?>" class="space-y-3">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor Email</label>
                            <input
                                type="email"
                                name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="vendor@example.com"
                                required
                            >
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="••••••••"
                                minlength="8"
                                required
                            >
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>

                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold"
                        >
                            🔑 Create Vendor Account
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Verification Info -->
        <?php if($vendor->verified_at): ?>
            <div class="bg-green-50 border border-green-300 rounded-lg p-6">
                <h3 class="text-lg font-bold text-green-900 mb-3">Verification</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-600">Verified By</p>
                        <p class="font-semibold"><?php echo e($vendor->verifiedBy->full_name); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Verified On</p>
                        <p class="font-semibold"><?php echo e($vendor->verified_at->format('M d, Y H:i')); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/vendors/show.blade.php ENDPATH**/ ?>