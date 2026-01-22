

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="mb-6">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin: 0 0 0.25rem;">Dashboard</h1>
    <p style="color: var(--text-muted); margin: 0;">Welcome back, <?php echo e(auth()->user()->full_name); ?>! Here's what's happening.</p>
</div>

<!-- Analytics Cards Row -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <!-- Congratulations Card -->
    <div class="lg:col-span-2 analytics-card">
        <div class="relative z-10">
            <p style="margin: 0 0 0.5rem; opacity: 0.9;">Congratulations! 🎉</p>
            <h2>PKR <?php echo e(number_format($stats['revenueThisMonth'], 0)); ?></h2>
            <p style="margin-bottom: 1rem;">Revenue this month</p>
            <a href="#" class="vuexy-btn" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem;">
                View Report
            </a>
        </div>
        <div style="position: absolute; right: 1rem; bottom: 0; font-size: 5rem; opacity: 0.2;">💰</div>
    </div>

    <!-- Sessions Card -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3><?php echo e($stats['totalMembers']); ?></h3>
            <p>Total Members</p>
            <div class="vuexy-stat-trend up">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                +12.5%
            </div>
        </div>
        <div class="vuexy-stat-icon primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
    </div>

    <!-- Active Members Card -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3><?php echo e($stats['activeMembers']); ?></h3>
            <p>Active Members</p>
            <div class="vuexy-stat-trend up">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                +8.2%
            </div>
        </div>
        <div class="vuexy-stat-icon success">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Pending Verification -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3><?php echo e($stats['pendingVerification']); ?></h3>
            <p>Pending Verification</p>
        </div>
        <div class="vuexy-stat-icon warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
    </div>

    <!-- Expired Members -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3><?php echo e($stats['expiredMembers']); ?></h3>
            <p>Expired Members</p>
        </div>
        <div class="vuexy-stat-icon danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
    </div>

    <!-- Suspended Members -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3><?php echo e($stats['suspendedMembers']); ?></h3>
            <p>Suspended</p>
        </div>
        <div class="vuexy-stat-icon info">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="vuexy-stat-card">
        <div class="vuexy-stat-content">
            <h3 style="font-size: 1.25rem;">PKR <?php echo e(number_format($stats['revenueThisMonth'], 0)); ?></h3>
            <p>Monthly Revenue</p>
        </div>
        <div class="vuexy-stat-icon primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Quick Actions Card -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Quick Actions</h3>
        </div>
        <div class="vuexy-card-body">
            <div class="grid grid-cols-2 gap-3">
                <a href="<?php echo e(route('admin.members.index')); ?>" class="vuexy-btn vuexy-btn-primary w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    Members
                </a>
                <a href="<?php echo e(route('admin.events.create')); ?>" class="vuexy-btn vuexy-btn-outline w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    New Event
                </a>
                <a href="<?php echo e(route('admin.documents.index', ['status' => 'pending'])); ?>" class="vuexy-btn vuexy-btn-outline w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    Documents
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="vuexy-btn vuexy-btn-outline w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Member Status Overview -->
    <div class="vuexy-card lg:col-span-2">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Member Status Overview</h3>
            <span class="vuexy-badge vuexy-badge-primary">This Month</span>
        </div>
        <div class="vuexy-card-body">
            <div class="space-y-6">
                <!-- Active Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Active Members</span>
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--success);"><?php echo e($stats['activeMembers']); ?></span>
                    </div>
                    <div class="vuexy-progress">
                        <div class="vuexy-progress-bar success" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['activeMembers'] / $stats['totalMembers'] * 100) : 0); ?>%;"></div>
                    </div>
                </div>

                <!-- Pending Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Pending Verification</span>
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--warning);"><?php echo e($stats['pendingVerification']); ?></span>
                    </div>
                    <div class="vuexy-progress">
                        <div class="vuexy-progress-bar warning" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['pendingVerification'] / $stats['totalMembers'] * 100) : 0); ?>%;"></div>
                    </div>
                </div>

                <!-- Suspended Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Suspended</span>
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--danger);"><?php echo e($stats['suspendedMembers']); ?></span>
                    </div>
                    <div class="vuexy-progress">
                        <div class="vuexy-progress-bar danger" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['suspendedMembers'] / $stats['totalMembers'] * 100) : 0); ?>%;"></div>
                    </div>
                </div>

                <!-- Expired Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Expired</span>
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);"><?php echo e($stats['expiredMembers']); ?></span>
                    </div>
                    <div class="vuexy-progress">
                        <div class="vuexy-progress-bar primary" style="width: <?php echo e($stats['totalMembers'] > 0 ? ($stats['expiredMembers'] / $stats['totalMembers'] * 100) : 0); ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recently Verified Members -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Recently Verified</h3>
            <a href="<?php echo e(route('admin.members.index')); ?>" style="font-size: 0.875rem; color: var(--primary); text-decoration: none;">View All</a>
        </div>
        <div class="vuexy-card-body" style="padding: 0;">
            <?php $__empty_1 = true; $__currentLoopData = $recentMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.members.show', $member)); ?>" class="activity-item" style="padding: 1rem 1.5rem; text-decoration: none;">
                    <div class="activity-icon" style="background: rgba(115,103,240,0.12); color: var(--primary);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title"><?php echo e($member->full_name); ?></p>
                        <span class="activity-time"><?php echo e($member->email); ?></span>
                    </div>
                    <span class="vuexy-badge vuexy-badge-success">Verified</span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <p>No recently verified members</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Event Registrations -->
    <div class="vuexy-card">
        <div class="vuexy-card-header">
            <h3 class="vuexy-card-title">Event Registrations</h3>
            <a href="#" style="font-size: 0.875rem; color: var(--primary); text-decoration: none;">View All</a>
        </div>
        <div class="vuexy-card-body" style="padding: 0;">
            <?php $__empty_1 = true; $__currentLoopData = $recentRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="activity-item" style="padding: 1rem 1.5rem;">
                    <div class="activity-icon" style="background: rgba(40,199,111,0.12); color: var(--success);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title"><?php echo e($registration->user->full_name); ?></p>
                        <span class="activity-time"><?php echo e($registration->event->title); ?></span>
                    </div>
                    <?php if($registration->status === 'registered'): ?>
                        <span class="vuexy-badge vuexy-badge-success">Registered</span>
                    <?php else: ?>
                        <span class="vuexy-badge vuexy-badge-warning"><?php echo e(ucfirst($registration->status)); ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <p>No recent registrations</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>