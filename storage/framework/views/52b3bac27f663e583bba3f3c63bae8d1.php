

<?php $__env->startSection('title', 'Events'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Upcoming Events</h1>
            <p class="text-blue-100">Join our community for unforgettable alpine experiences</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <form method="GET" class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="<?php echo e(request('search')); ?>"
                        placeholder="Title, location, region..."
                        class="input"
                    >
                </div>

                <!-- Event Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="event_type" class="input">
                        <option value="">All Types</option>
                        <option value="championship" <?php echo e(request('event_type') === 'championship' ? 'selected' : ''); ?>>Championship</option>
                        <option value="training" <?php echo e(request('event_type') === 'training' ? 'selected' : ''); ?>>Training</option>
                        <option value="expedition" <?php echo e(request('event_type') === 'expedition' ? 'selected' : ''); ?>>Expedition</option>
                        <option value="meetup" <?php echo e(request('event_type') === 'meetup' ? 'selected' : ''); ?>>Meetup</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region); ?>" <?php echo e(request('region') === $region ? 'selected' : ''); ?>>
                                <?php echo e($region); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">When</label>
                    <select name="filter" class="input">
                        <option value="upcoming" <?php echo e(request('filter', 'upcoming') === 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
                        <option value="past" <?php echo e(request('filter') === 'past' ? 'selected' : ''); ?>>Past Events</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>

        <!-- Events Grid -->
        <?php if($events->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card hover:shadow-lg transition-shadow">
                        <!-- Event Type Badge -->
                        <div class="mb-3">
                            <span class="badge bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($event->event_type)); ?>

                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            <?php echo e($event->title); ?>

                        </h3>

                        <!-- Location -->
                        <p class="text-sm text-gray-600 mb-2">
                            📍 <?php echo e($event->location); ?>, <?php echo e($event->region); ?>

                        </p>

                        <!-- Dates -->
                        <p class="text-sm text-gray-600 mb-3">
                            📅 <?php echo e($event->start_date->format('M d, Y')); ?>

                            <?php if($event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d')): ?>
                                - <?php echo e($event->end_date->format('M d, Y')); ?>

                            <?php endif; ?>
                        </p>

                        <!-- Pricing -->
                        <div class="mb-3 p-2 bg-gray-50 rounded">
                            <p class="text-xs text-gray-600">Starting from</p>
                            <p class="text-lg font-bold text-blue-600">
                                Rs. <?php echo e(number_format($event->price_member)); ?>

                                <span class="text-xs text-gray-500">/ member</span>
                            </p>
                        </div>

                        <!-- Availability -->
                        <?php
                            $registered = $event->registrations()->where('status', 'registered')->count();
                            $available = max(0, $event->max_participants - $registered);
                        ?>

                        <div class="mb-4">
                            <?php if($available > 0): ?>
                                <div class="text-xs text-green-600 font-semibold mb-1">
                                    <?php echo e($available); ?> slots available
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div
                                        class="bg-green-500 h-2 rounded-full"
                                        style="width: <?php echo e(($registered / $event->max_participants) * 100); ?>%"
                                    ></div>
                                </div>
                            <?php else: ?>
                                <div class="text-xs text-red-600 font-semibold">
                                    🔴 Waitlist Available
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- View Button -->
                        <a
                            href="<?php echo e(route('events.show', $event)); ?>"
                            class="btn-primary w-full text-center block"
                        >
                            View Details
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                <?php echo e($events->links()); ?>

            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="card text-center py-12">
                <p class="text-2xl font-bold text-gray-600 mb-2">No events found</p>
                <p class="text-gray-500 mb-4">Try adjusting your filters</p>
                <a href="<?php echo e(route('events.index')); ?>" class="btn-primary inline-block">
                    Clear Filters
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/events/index.blade.php ENDPATH**/ ?>