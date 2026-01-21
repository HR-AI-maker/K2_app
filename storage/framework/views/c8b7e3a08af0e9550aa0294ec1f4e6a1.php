<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Welcome back, <?php echo e($user->first_name); ?>! 👋</h1>
            <p class="text-gray-600 mt-2">
                <?php if($membershipExpired): ?>
                    Your membership has expired. <a href="<?php echo e(route('profile.membership')); ?>" class="text-blue-600 hover:underline">Renew now</a>
                <?php elseif($daysUntilExpiry !== null && $daysUntilExpiry <= 30): ?>
                    Your membership expires in <?php echo e($daysUntilExpiry); ?> days
                <?php else: ?>
                    Your membership is active and in good standing
                <?php endif; ?>
            </p>
        </div>

        <!-- Profile Completion Banner -->
        <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Complete Your Profile</h2>
                    <p class="text-blue-100"><?php echo e($profileCompleteness); ?>% complete - You're doing great!</p>
                </div>
                <div class="text-5xl font-bold opacity-20"><?php echo e($profileCompleteness); ?>%</div>
            </div>
            <div class="mt-4 bg-blue-400 rounded-full h-3 overflow-hidden">
                <div class="bg-white h-full rounded-full" style="width: <?php echo e($profileCompleteness); ?>%"></div>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="<?php echo e(route('profile.edit')); ?>" class="px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50">
                    Edit Profile
                </a>
                <a href="<?php echo e(route('profile.documents')); ?>" class="px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-800">
                    Upload Documents
                </a>
                <a href="<?php echo e(route('profile.medical')); ?>" class="px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-800">
                    Medical Info
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left Column) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-blue-600"><?php echo e($stats['events_registered']); ?></p>
                        <p class="text-sm text-gray-600">Events Registered</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-green-600"><?php echo e($stats['expeditions_applied']); ?></p>
                        <p class="text-sm text-gray-600">Expeditions Applied</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-purple-600"><?php echo e($stats['community_posts']); ?></p>
                        <p class="text-sm text-gray-600">Posts Created</p>
                    </div>
                    <div class="card text-center">
                        <p class="text-3xl font-bold text-yellow-600"><?php echo e($stats['badges_earned']); ?></p>
                        <p class="text-sm text-gray-600">Badges Earned</p>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="card">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">📅 Upcoming Events</h2>
                        <a href="<?php echo e(route('events.index')); ?>" class="text-blue-600 hover:underline text-sm">View All</a>
                    </div>
                    <?php if($upcomingEvents->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <p class="font-semibold"><?php echo e($reg->event->title); ?></p>
                                    <p class="text-sm text-gray-600">
                                        📍 <?php echo e($reg->event->location); ?> • 📅 <?php echo e($reg->event->start_date->format('M d, Y')); ?>

                                    </p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-6">No upcoming events. <a href="<?php echo e(route('events.index')); ?>" class="text-blue-600 hover:underline">Browse events</a></p>
                    <?php endif; ?>
                </div>

                <!-- Expedition Applications -->
                <div class="card">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">🏔️ Expedition Applications</h2>
                        <a href="<?php echo e(route('expeditions.index')); ?>" class="text-blue-600 hover:underline text-sm">Browse</a>
                    </div>
                    <?php if($expeditionApps->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $expeditionApps->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded-lg p-3 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold"><?php echo e($app->expedition->title); ?></p>
                                            <p class="text-sm text-gray-600">Applied <?php echo e($app->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <span class="badge
                                            <?php if($app->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                            <?php elseif($app->status === 'approved'): ?> bg-green-100 text-green-800
                                            <?php elseif($app->status === 'rejected'): ?> bg-red-100 text-red-800
                                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>
                                        ">
                                            <?php echo e(ucfirst($app->status)); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-6">No applications yet. <a href="<?php echo e(route('expeditions.index')); ?>" class="text-blue-600 hover:underline">Apply for expeditions</a></p>
                    <?php endif; ?>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">📊 Recent Activity</h2>
                    <?php if(count($activities) > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-4 pb-4 border-b last:border-b-0">
                                    <div class="text-2xl"><?php echo e($activity['icon']); ?></div>
                                    <div class="flex-1">
                                        <p class="font-semibold"><?php echo e($activity['title']); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e($activity['description']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1"><?php echo e($activity['date']->diffForHumans()); ?></p>
                                    </div>
                                    <span class="badge text-xs <?php echo e($activity['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($activity['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e(ucfirst($activity['status'])); ?>

                                    </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-6">No recent activity</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar (Right Column) -->
            <div class="space-y-8">
                <!-- Quick Actions -->
                <div class="card">
                    <h3 class="text-xl font-bold mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="<?php echo e(route('events.index')); ?>" class="block p-3 rounded-lg border hover:bg-blue-50 hover:border-blue-300 transition">
                            🎫 Browse Events
                        </a>
                        <a href="<?php echo e(route('expeditions.index')); ?>" class="block p-3 rounded-lg border hover:bg-green-50 hover:border-green-300 transition">
                            ⛰️ Browse Expeditions
                        </a>
                        <a href="<?php echo e(route('profile.documents')); ?>" class="block p-3 rounded-lg border hover:bg-purple-50 hover:border-purple-300 transition">
                            📄 Upload Documents
                        </a>
                        <a href="<?php echo e(route('profile.membership')); ?>" class="block p-3 rounded-lg border hover:bg-yellow-50 hover:border-yellow-300 transition">
                            🏷️ Membership Status
                        </a>
                    </div>
                </div>

                <!-- Membership Card -->
                <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
                    <h3 class="text-lg font-bold mb-3">💳 Membership</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-600">Tier</p>
                            <p class="text-lg font-bold capitalize"><?php echo e($user->membership_tier ?? 'None'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Status</p>
                            <p class="text-lg font-bold capitalize">
                                <?php if($membershipExpired): ?>
                                    <span class="text-red-600">Expired</span>
                                <?php else: ?>
                                    <span class="text-green-600">Active</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php if($latestMembership): ?>
                            <div>
                                <p class="text-xs text-gray-600">Expires</p>
                                <p class="text-sm font-semibold"><?php echo e($latestMembership->expires_at->format('M d, Y')); ?></p>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo e(route('profile.membership')); ?>" class="block mt-4 text-center p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Documents Status -->
                <div class="card">
                    <h3 class="text-lg font-bold mb-3">📋 Documents</h3>
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['documents_verified']); ?>/<?php echo e($stats['documents_total']); ?></p>
                        <p class="text-xs text-gray-600">Verified Documents</p>
                    </div>
                    <?php if($stats['documents_total'] < 4): ?>
                        <p class="text-sm text-yellow-700 bg-yellow-50 p-3 rounded mb-3">
                            ⚠️ Please upload all required documents
                        </p>
                    <?php endif; ?>
                    <a href="<?php echo e(route('profile.documents')); ?>" class="w-full text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                        Manage Documents
                    </a>
                </div>

                <!-- Badges -->
                <?php if($stats['badges_earned'] > 0): ?>
                    <div class="card">
                        <h3 class="text-lg font-bold mb-3">🏆 Badges</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <?php $__currentLoopData = $user->badges->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-center p-2 rounded-lg bg-yellow-50">
                                    <p class="text-2xl">🏅</p>
                                    <p class="text-xs text-gray-700 truncate"><?php echo e($badge->name); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <a href="<?php echo e(route('profile.badges')); ?>" class="mt-3 text-sm text-blue-600 hover:underline">View all badges →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/dashboard.blade.php ENDPATH**/ ?>