<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Admin Dashboard</h1>
    <p class="text-gray-600 mt-2">Welcome, <?php echo e(auth()->user()->full_name); ?></p>
</div>

<!-- System Health Overview -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
        <p class="text-gray-600 text-sm font-semibold">Total Members</p>
        <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo e($stats['totalMembers']); ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
        <p class="text-gray-600 text-sm font-semibold">Active Members</p>
        <p class="text-3xl font-bold text-green-600 mt-2"><?php echo e($stats['activeMembers']); ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
        <p class="text-gray-600 text-sm font-semibold">Pending Verification</p>
        <p class="text-3xl font-bold text-yellow-600 mt-2"><?php echo e($stats['pendingVerification']); ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
        <p class="text-gray-600 text-sm font-semibold">Expired</p>
        <p class="text-3xl font-bold text-red-600 mt-2"><?php echo e($stats['expiredMembers']); ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
        <p class="text-gray-600 text-sm font-semibold">Revenue This Month</p>
        <p class="text-3xl font-bold text-purple-600 mt-2">PKR <?php echo e(number_format($stats['revenueThisMonth'], 0)); ?></p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="<?php echo e(route('admin.members.index')); ?>" class="p-4 border rounded-lg hover:bg-blue-50 text-center transition">
                <p class="font-semibold text-blue-600">👥 Manage Members</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-green-50 text-center transition">
                <p class="font-semibold text-green-600">📅 Create Event</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-purple-50 text-center transition">
                <p class="font-semibold text-purple-600">📊 View Reports</p>
            </a>
            <a href="#" class="p-4 border rounded-lg hover:bg-red-50 text-center transition">
                <p class="font-semibold text-red-600">🚨 Safety Records</p>
            </a>
        </div>
    </div>

    <!-- Member Status Overview -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Member Status Overview</h2>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Active</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['activeMembers'] / $stats['totalMembers'] * 100) : 0); ?>%"></div>
                    </div>
                    <span class="font-bold"><?php echo e($stats['activeMembers']); ?></span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Suspended</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['suspendedMembers'] / $stats['totalMembers'] * 100) : 0); ?>%"></div>
                    </div>
                    <span class="font-bold"><?php echo e($stats['suspendedMembers']); ?></span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Expired</span>
                <div class="flex items-center gap-2">
                    <div class="w-32 bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['expiredMembers'] / $stats['totalMembers'] * 100) : 0); ?>%"></div>
                    </div>
                    <span class="font-bold"><?php echo e($stats['expiredMembers']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Members -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Recently Verified Members</h2>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            <?php $__empty_1 = true; $__currentLoopData = $recentMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50">
                    <div>
                        <p class="font-semibold"><?php echo e($member->full_name); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($member->email); ?></p>
                    </div>
                    <a href="<?php echo e(route('admin.members.show', $member)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">View</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600 text-center py-4">No recently verified members</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Recent Event Registrations</h2>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            <?php $__empty_1 = true; $__currentLoopData = $recentRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50">
                    <div>
                        <p class="font-semibold"><?php echo e($registration->user->full_name); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($registration->event->title); ?></p>
                    </div>
                    <span class="inline-block px-3 py-1 bg-<?php echo e($registration->status === 'registered' ? 'green' : 'yellow'); ?>-100 text-<?php echo e($registration->status === 'registered' ? 'green' : 'yellow'); ?>-800 text-xs font-semibold rounded-full">
                        <?php echo e(ucfirst($registration->status)); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600 text-center py-4">No recent registrations</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>