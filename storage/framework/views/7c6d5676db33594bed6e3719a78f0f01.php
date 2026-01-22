

<?php $__env->startSection('title', 'Events Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Events Management</h1>
            <p class="text-gray-600 mt-2">Manage, create, and track all events</p>
        </div>
        <a href="<?php echo e(route('admin.events.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
            ➕ Create Event
        </a>
    </div>
</div>

<!-- Event Statistics -->
<div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['published']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Draft</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['draft']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Upcoming</p>
        <p class="text-2xl font-bold text-purple-600"><?php echo e($stats['upcoming']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Cancelled</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['cancelled']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Completed</p>
        <p class="text-2xl font-bold text-gray-600"><?php echo e($stats['completed']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.events.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Title, location..." class="input">
            </div>

            <!-- Event Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                <select name="event_type" class="input">
                    <option value="">All Types</option>
                    <option value="championship" <?php if(request('event_type') === 'championship'): echo 'selected'; endif; ?>>Championship</option>
                    <option value="training" <?php if(request('event_type') === 'training'): echo 'selected'; endif; ?>>Training</option>
                    <option value="expedition" <?php if(request('event_type') === 'expedition'): echo 'selected'; endif; ?>>Expedition</option>
                    <option value="meetup" <?php if(request('event_type') === 'meetup'): echo 'selected'; endif; ?>>Meetup</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input">
                    <option value="">All Statuses</option>
                    <option value="draft" <?php if(request('status') === 'draft'): echo 'selected'; endif; ?>>Draft</option>
                    <option value="published" <?php if(request('status') === 'published'): echo 'selected'; endif; ?>>Published</option>
                    <option value="cancelled" <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                    <option value="completed" <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>>Completed</option>
                </select>
            </div>

            <!-- Region Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                <select name="region" class="input">
                    <option value="">All Regions</option>
                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region); ?>" <?php if(request('region') === $region): echo 'selected'; endif; ?>><?php echo e($region); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Start Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" class="input">
            </div>

            <!-- End Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" class="input">
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Apply Filters
            </button>
            <a href="<?php echo e(route('admin.events.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Events Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Participants</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900"><?php echo e($event->title); ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($event->event_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($event->location); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php echo e($event->start_date->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold">
                                <?php
                                    $registered = $event->registrations()->where('status', 'registered')->count();
                                    $max = $event->max_participants;
                                ?>
                                <?php echo e($registered); ?>/<?php echo e($max); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                <?php if($event->status === 'published'): ?> bg-green-100 text-green-800
                                <?php elseif($event->status === 'draft'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($event->status === 'cancelled'): ?> bg-red-100 text-red-800
                                <?php elseif($event->status === 'completed'): ?> bg-blue-100 text-blue-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($event->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No events found. <a href="<?php echo e(route('admin.events.create')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">Create your first event</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($events->count() > 0): ?>
        <div class="px-6 py-4 bg-gray-50 border-t">
            <?php echo e($events->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/events/index.blade.php ENDPATH**/ ?>