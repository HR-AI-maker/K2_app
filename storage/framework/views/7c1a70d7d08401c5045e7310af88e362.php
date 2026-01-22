

<?php $__env->startSection('title', 'Expeditions'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Alpine Expeditions</h1>
            <p class="text-green-100">Challenge yourself on Pakistan's highest peaks</p>
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
                        placeholder="Expedition, location..."
                        class="input"
                    >
                </div>

                <!-- Difficulty -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                    <select name="difficulty" class="input">
                        <option value="">All Levels</option>
                        <option value="beginner" <?php echo e(request('difficulty') === 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                        <option value="intermediate" <?php echo e(request('difficulty') === 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                        <option value="advanced" <?php echo e(request('difficulty') === 'advanced' ? 'selected' : ''); ?>>Advanced</option>
                        <option value="expert" <?php echo e(request('difficulty') === 'expert' ? 'selected' : ''); ?>>Expert</option>
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

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="input">
                        <option value="">All Expeditions</option>
                        <option value="open" <?php echo e(request('status') === 'open' ? 'selected' : ''); ?>>Open for Applications</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Expeditions Grid -->
        <?php if($expeditions->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__currentLoopData = $expeditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expedition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $approvedCount = $expedition->applications()->where('status', 'approved')->count();
                        $available = max(0, $expedition->max_participants - $approvedCount);
                    ?>
                    <div class="card hover:shadow-lg transition-shadow">
                        <!-- Difficulty Badge -->
                        <div class="mb-3">
                            <?php
                                $colors = [
                                    'beginner' => 'bg-green-100 text-green-800',
                                    'intermediate' => 'bg-yellow-100 text-yellow-800',
                                    'advanced' => 'bg-orange-100 text-orange-800',
                                    'expert' => 'bg-red-100 text-red-800',
                                ];
                                $color = $colors[$expedition->difficulty_level] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="badge <?php echo e($color); ?>">
                                <?php echo e(ucfirst($expedition->difficulty_level)); ?>

                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            <?php echo e($expedition->title); ?>

                        </h3>

                        <!-- Location -->
                        <p class="text-sm text-gray-600 mb-2">
                            📍 <?php echo e($expedition->location); ?>, <?php echo e($expedition->region); ?>

                        </p>

                        <!-- Duration -->
                        <p class="text-sm text-gray-600 mb-3">
                            📅 <?php echo e($expedition->start_date->format('M d')); ?> - <?php echo e($expedition->end_date->format('M d, Y')); ?>

                        </p>

                        <!-- Permit Info -->
                        <?php if($expedition->permit_required): ?>
                            <p class="text-xs bg-blue-50 text-blue-700 p-2 rounded mb-3">
                                📜 Permit required
                            </p>
                        <?php endif; ?>

                        <!-- Availability -->
                        <div class="mb-4">
                            <?php if($expedition->status === 'open'): ?>
                                <?php if($available > 0): ?>
                                    <div class="text-xs text-green-600 font-semibold mb-1">
                                        <?php echo e($available); ?> <?php echo e($available === 1 ? 'slot' : 'slots'); ?> available
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div
                                            class="bg-green-500 h-2 rounded-full"
                                            style="width: <?php echo e(($approvedCount / $expedition->max_participants) * 100); ?>%"
                                        ></div>
                                    </div>
                                <?php else: ?>
                                    <div class="text-xs text-red-600 font-semibold">
                                        🔴 Waitlist Available
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-xs text-gray-600 font-semibold">
                                    ⛔ Closed
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- View Button -->
                        <a
                            href="<?php echo e(route('expeditions.show', $expedition)); ?>"
                            class="btn-primary w-full text-center block"
                        >
                            View Details
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                <?php echo e($expeditions->links()); ?>

            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="card text-center py-12">
                <p class="text-2xl font-bold text-gray-600 mb-2">No expeditions found</p>
                <p class="text-gray-500 mb-4">Try adjusting your filters</p>
                <a href="<?php echo e(route('expeditions.index')); ?>" class="btn-primary inline-block">
                    Clear Filters
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/expeditions/index.blade.php ENDPATH**/ ?>