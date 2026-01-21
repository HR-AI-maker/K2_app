<?php $__env->startSection('title', $expedition->title); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900"><?php echo e($expedition->title); ?></h1>
            <p class="text-gray-600 mt-2"><?php echo e($expedition->location); ?> • <?php echo e($expedition->region); ?></p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.expeditions.edit', $expedition)); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Edit
            </a>
            <a href="<?php echo e(route('admin.expeditions.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                ← Back to List
            </a>
        </div>
    </div>
</div>

<!-- Status Badge and Actions -->
<div class="grid grid-cols-4 gap-4 mb-8">
    <!-- Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Status</p>
        <div class="flex items-center gap-2">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                <?php if($expedition->status === 'open'): ?> bg-green-100 text-green-800
                <?php elseif($expedition->status === 'closed'): ?> bg-red-100 text-red-800
                <?php elseif($expedition->status === 'completed'): ?> bg-blue-100 text-blue-800
                <?php elseif($expedition->status === 'cancelled'): ?> bg-gray-100 text-gray-800
                <?php else: ?> bg-yellow-100 text-yellow-800
                <?php endif; ?>
            ">
                <?php echo e(ucfirst($expedition->status)); ?>

            </span>
        </div>
    </div>

    <!-- Difficulty Level -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Difficulty</p>
        <p class="text-lg font-bold text-gray-900"><?php echo e(ucfirst($expedition->difficulty_level)); ?></p>
    </div>

    <!-- Participants -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Max Participants</p>
        <p class="text-lg font-bold text-gray-900"><?php echo e($expedition->max_participants); ?></p>
    </div>

    <!-- Permit Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Permit Required</p>
        <p class="text-lg font-bold text-gray-900">
            <?php echo e($expedition->permit_required ? '✓ Yes' : '✗ No'); ?>

        </p>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="col-span-2 space-y-6">
        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Expedition Details</h2>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Start Date</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($expedition->start_date->format('M d, Y')); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">End Date</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($expedition->end_date->format('M d, Y')); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Duration</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($expedition->start_date->diffInDays($expedition->end_date)); ?> days</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Created By</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($expedition->creator->full_name ?? 'Unknown'); ?></p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-2">Description</p>
                <p class="text-gray-700 whitespace-pre-line"><?php echo e($expedition->description); ?></p>
            </div>

            <?php if($expedition->permit_required && $expedition->permit_details): ?>
                <div class="mt-6 pt-6 border-t">
                    <p class="text-sm text-gray-600 mb-2">Permit Details</p>
                    <p class="text-gray-700 whitespace-pre-line"><?php echo e($expedition->permit_details); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Status Actions -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Status Management</h2>
            <div class="flex gap-4 flex-wrap">
                <?php if($expedition->status === 'planning'): ?>
                    <form method="POST" action="<?php echo e(route('admin.expeditions.open', $expedition)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Open for Applications
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($expedition->status === 'open'): ?>
                    <form method="POST" action="<?php echo e(route('admin.expeditions.close', $expedition)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Close Applications
                        </button>
                    </form>
                <?php endif; ?>

                <?php if(in_array($expedition->status, ['open', 'closed'])): ?>
                    <form method="POST" action="<?php echo e(route('admin.expeditions.complete', $expedition)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Mark as Completed
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($expedition->status !== 'completed' && $expedition->status !== 'cancelled'): ?>
                    <form method="POST" action="<?php echo e(route('admin.expeditions.cancel', $expedition)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700" onclick="return confirm('Are you sure?')">
                            Cancel Expedition
                        </button>
                    </form>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.expeditions.destroy', $expedition)); ?>" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900" onclick="return confirm('Delete permanently?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Applications Stats -->
        <div class="bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Applications</h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Total Applications</span>
                    <span class="text-2xl font-bold text-gray-900"><?php echo e($applicationStats['total']); ?></span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Pending</span>
                    <span class="text-2xl font-bold text-yellow-600"><?php echo e($applicationStats['pending']); ?></span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Approved</span>
                    <span class="text-2xl font-bold text-green-600"><?php echo e($applicationStats['approved']); ?></span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Rejected</span>
                    <span class="text-2xl font-bold text-red-600"><?php echo e($applicationStats['rejected']); ?></span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Cancelled</span>
                    <span class="text-2xl font-bold text-gray-600"><?php echo e($applicationStats['cancelled']); ?></span>
                </div>
            </div>

            <a href="<?php echo e(route('admin.expeditions.applications', $expedition)); ?>" class="mt-6 block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                View All Applications
            </a>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Info</h3>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Location</p>
                    <p class="font-semibold text-gray-900"><?php echo e($expedition->location); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Region</p>
                    <p class="font-semibold text-gray-900"><?php echo e($expedition->region); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Created</p>
                    <p class="font-semibold text-gray-900"><?php echo e($expedition->created_at->format('M d, Y')); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Updated</p>
                    <p class="font-semibold text-gray-900"><?php echo e($expedition->updated_at->format('M d, Y')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/expeditions/show.blade.php ENDPATH**/ ?>