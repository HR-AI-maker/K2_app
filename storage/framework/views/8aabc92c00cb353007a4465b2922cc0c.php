<?php $__env->startSection('title', $event->title); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <a href="<?php echo e(route('events.index')); ?>" class="text-blue-100 hover:text-white mb-4 inline-block">
                ← Back to Events
            </a>
            <h1 class="text-4xl font-bold mb-2"><?php echo e($event->title); ?></h1>
            <div class="flex gap-3 flex-wrap">
                <span class="badge bg-blue-200 text-blue-900"><?php echo e(ucfirst($event->event_type)); ?></span>
                <?php if($isFull): ?>
                    <span class="badge bg-red-200 text-red-900">Waitlist Available</span>
                <?php else: ?>
                    <span class="badge bg-green-200 text-green-900"><?php echo e($availableSlots); ?> slots available</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Event Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">START DATE</p>
                        <p class="font-bold text-lg"><?php echo e($event->start_date->format('M d')); ?></p>
                        <p class="text-xs text-gray-600"><?php echo e($event->start_date->format('Y')); ?></p>
                    </div>
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">DURATION</p>
                        <p class="font-bold text-lg">
                            <?php echo e($event->start_date->diffInDays($event->end_date) + 1); ?> days
                        </p>
                    </div>
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">LOCATION</p>
                        <p class="font-bold text-lg"><?php echo e($event->region); ?></p>
                    </div>
                </div>

                <!-- Description -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">About This Event</h2>
                    <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($event->description); ?></p>
                </div>

                <!-- Details -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-6">Event Details</h2>
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">📍 Location</h3>
                            <p class="text-gray-700"><?php echo e($event->location); ?>, <?php echo e($event->region); ?></p>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">📅 Schedule</h3>
                            <p class="text-gray-700">
                                <strong>Start:</strong> <?php echo e($event->start_date->format('F d, Y \a\t g:i A')); ?><br>
                                <strong>End:</strong> <?php echo e($event->end_date->format('F d, Y \a\t g:i A')); ?>

                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">👥 Participants</h3>
                            <p class="text-gray-700">
                                <strong>Total Capacity:</strong> <?php echo e($event->max_participants); ?><br>
                                <strong>Registered:</strong> <?php echo e($stats['confirmed']); ?><br>
                                <strong>Waitlisted:</strong> <?php echo e($stats['waitlisted']); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <?php if($event->eligibility_requirements && count($event->eligibility_requirements) > 0): ?>
                    <div class="card">
                        <h2 class="text-2xl font-bold mb-4">Requirements</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <?php $__currentLoopData = $event->eligibility_requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($requirement); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Organizer Info -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">Organizer</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            <?php echo e(substr($event->creator->first_name, 0, 1)); ?>

                        </div>
                        <div>
                            <p class="font-semibold"><?php echo e($event->creator->full_name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($event->creator->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Registration -->
            <div>
                <!-- Registration Card -->
                <div class="card sticky top-4">
                    <h2 class="text-2xl font-bold mb-4">Registration</h2>

                    <!-- Pricing -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600 mb-1">Member Price</p>
                        <p class="text-3xl font-bold text-blue-600 mb-2">
                            Rs. <?php echo e(number_format($event->price_member)); ?>

                        </p>
                        <p class="text-xs text-gray-600">
                            Non-member: Rs. <?php echo e(number_format($event->price_nonmember)); ?>

                        </p>
                    </div>

                    <!-- Status -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <?php if($userRegistration): ?>
                            <p class="font-semibold text-blue-900">
                                Status: <span class="uppercase text-blue-600"><?php echo e($userRegistration->status); ?></span>
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                Registered on <?php echo e($userRegistration->registered_at->format('M d, Y')); ?>

                            </p>
                        <?php else: ?>
                            <?php if($isFull): ?>
                                <p class="text-sm text-gray-700">This event is full, but you can join the waitlist.</p>
                            <?php else: ?>
                                <p class="text-sm text-gray-700">
                                    <?php echo e($availableSlots); ?> <?php echo e($availableSlots === 1 ? 'slot' : 'slots'); ?> available
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <?php if(auth()->check()): ?>
                        <?php if(!$userRegistration): ?>
                            <form method="POST" action="<?php echo e(route('events.register', $event)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary w-full mb-3">
                                    <?php echo e($isFull ? 'Join Waitlist' : 'Register Now'); ?>

                                </button>
                            </form>
                        <?php else: ?>
                            <button disabled class="btn-primary w-full opacity-50 cursor-not-allowed mb-3">
                                Already Registered
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-primary w-full text-center block mb-3">
                            Login to Register
                        </a>
                        <p class="text-xs text-gray-600 text-center">
                            Don't have an account?
                            <a href="<?php echo e(route('register')); ?>" class="text-blue-600 hover:underline">Sign up</a>
                        </p>
                    <?php endif; ?>

                    <!-- Additional Info -->
                    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-xs font-semibold text-yellow-900 mb-2">ℹ️ Before You Register</p>
                        <ul class="text-xs text-gray-700 space-y-1">
                            <li>✓ Ensure you meet all requirements</li>
                            <li>✓ Complete your profile</li>
                            <li>✓ Upload required documents</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/events/show.blade.php ENDPATH**/ ?>