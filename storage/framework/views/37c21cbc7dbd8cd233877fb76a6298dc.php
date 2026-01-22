

<?php $__env->startSection('title', 'Members Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Members Management</h1>
            <p class="text-gray-600 mt-2">Manage and verify member accounts</p>
        </div>
    </div>
</div>

<!-- Member Statistics -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Active</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['active']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Expired</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['expired']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Suspended</p>
        <p class="text-2xl font-bold text-purple-600"><?php echo e($stats['suspended']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Name, email, phone..." class="input">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input">
                    <option value="">All Statuses</option>
                    <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Active</option>
                    <option value="expired" <?php if(request('status') === 'expired'): echo 'selected'; endif; ?>>Expired</option>
                    <option value="suspended" <?php if(request('status') === 'suspended'): echo 'selected'; endif; ?>>Suspended</option>
                </select>
            </div>

            <!-- Tier Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Membership Tier</label>
                <select name="tier" class="input">
                    <option value="">All Tiers</option>
                    <option value="pending" <?php if(request('tier') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                    <option value="standard" <?php if(request('tier') === 'standard'): echo 'selected'; endif; ?>>Standard</option>
                    <option value="premium" <?php if(request('tier') === 'premium'): echo 'selected'; endif; ?>>Premium</option>
                    <option value="lifetime" <?php if(request('tier') === 'lifetime'): echo 'selected'; endif; ?>>Lifetime</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                <select name="type" class="input">
                    <option value="">All Types</option>
                    <option value="local" <?php if(request('type') === 'local'): echo 'selected'; endif; ?>>Local</option>
                    <option value="foreign" <?php if(request('type') === 'foreign'): echo 'selected'; endif; ?>>Foreign</option>
                </select>
            </div>

            <!-- Discipline Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discipline</label>
                <select name="discipline" class="input">
                    <option value="">All Disciplines</option>
                    <option value="trekking" <?php if(request('discipline') === 'trekking'): echo 'selected'; endif; ?>>Trekking</option>
                    <option value="rock" <?php if(request('discipline') === 'rock'): echo 'selected'; endif; ?>>Rock Climbing</option>
                    <option value="ice" <?php if(request('discipline') === 'ice'): echo 'selected'; endif; ?>>Ice Climbing</option>
                    <option value="mountaineering" <?php if(request('discipline') === 'mountaineering'): echo 'selected'; endif; ?>>Mountaineering</option>
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Apply Filters
            </button>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Members Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tier</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900"><?php echo e($member->full_name); ?></p>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($member->email); ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                <?php if($member->membership_status === 'active'): ?> bg-green-100 text-green-800
                                <?php elseif($member->membership_status === 'expired'): ?> bg-red-100 text-red-800
                                <?php elseif($member->membership_status === 'suspended'): ?> bg-purple-100 text-purple-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($member->membership_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge">
                                <?php echo e(ucfirst($member->membership_tier)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <?php if($member->membership_verified_at): ?>
                                ✓ <?php echo e(ucfirst($member->user_type)); ?>

                            <?php else: ?>
                                ⏳ Pending
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php echo e($member->created_at->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.members.show', $member)); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No members found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($members->count() > 0): ?>
        <div class="px-6 py-4 bg-gray-50 border-t">
            <?php echo e($members->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/members/index.blade.php ENDPATH**/ ?>