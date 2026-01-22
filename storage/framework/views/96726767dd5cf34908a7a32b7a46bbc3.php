

<?php $__env->startSection('title', 'Create Expedition'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Create Expedition</h1>
            <p class="text-gray-600 mt-2">Add a new alpine expedition to the system</p>
        </div>
        <a href="<?php echo e(route('admin.expeditions.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to List
        </a>
    </div>
</div>

<!-- Form -->
<div class="bg-white rounded-lg shadow p-8 max-w-4xl">
    <form method="POST" action="<?php echo e(route('admin.expeditions.store')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-2 gap-6">
            <!-- Title -->
            <div class="col-span-2">
                <label for="title" class="block text-sm font-bold text-gray-900 mb-2">Expedition Title *</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="<?php echo e(old('title')); ?>"
                    placeholder="e.g., K2 Base Camp Trek"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-bold text-gray-900 mb-2">Location *</label>
                <input
                    type="text"
                    name="location"
                    id="location"
                    value="<?php echo e(old('location')); ?>"
                    placeholder="e.g., Karakoram Range"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Region -->
            <div>
                <label for="region" class="block text-sm font-bold text-gray-900 mb-2">Region *</label>
                <select
                    name="region"
                    id="region"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                    <option value="">Select Region</option>
                    <option value="Karakoram" <?php echo e(old('region') === 'Karakoram' ? 'selected' : ''); ?>>Karakoram</option>
                    <option value="Himalayas" <?php echo e(old('region') === 'Himalayas' ? 'selected' : ''); ?>>Himalayas</option>
                    <option value="Hindu Kush" <?php echo e(old('region') === 'Hindu Kush' ? 'selected' : ''); ?>>Hindu Kush</option>
                    <option value="Northern Areas" <?php echo e(old('region') === 'Northern Areas' ? 'selected' : ''); ?>>Northern Areas</option>
                </select>
                <?php $__errorArgs = ['region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Difficulty Level -->
            <div>
                <label for="difficulty_level" class="block text-sm font-bold text-gray-900 mb-2">Difficulty Level *</label>
                <select
                    name="difficulty_level"
                    id="difficulty_level"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                    <option value="">Select Difficulty</option>
                    <option value="beginner" <?php echo e(old('difficulty_level') === 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                    <option value="intermediate" <?php echo e(old('difficulty_level') === 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                    <option value="advanced" <?php echo e(old('difficulty_level') === 'advanced' ? 'selected' : ''); ?>>Advanced</option>
                    <option value="expert" <?php echo e(old('difficulty_level') === 'expert' ? 'selected' : ''); ?>>Expert</option>
                </select>
                <?php $__errorArgs = ['difficulty_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-sm font-bold text-gray-900 mb-2">Start Date *</label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    value="<?php echo e(old('start_date')); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-sm font-bold text-gray-900 mb-2">End Date *</label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    value="<?php echo e(old('end_date')); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Max Participants -->
            <div>
                <label for="max_participants" class="block text-sm font-bold text-gray-900 mb-2">Max Participants *</label>
                <input
                    type="number"
                    name="max_participants"
                    id="max_participants"
                    value="<?php echo e(old('max_participants', 20)); ?>"
                    min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                <?php $__errorArgs = ['max_participants'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Permit Required -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="permit_required"
                    id="permit_required"
                    value="1"
                    <?php echo e(old('permit_required') ? 'checked' : ''); ?>

                    class="h-4 w-4 text-green-600 rounded"
                >
                <label for="permit_required" class="ml-3 text-sm font-bold text-gray-900">
                    Permit Required?
                </label>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-bold text-gray-900 mb-2">Description *</label>
            <textarea
                name="description"
                id="description"
                rows="8"
                placeholder="Detailed description of the expedition..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                required
            ><?php echo e(old('description')); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Permit Details -->
        <div>
            <label for="permit_details" class="block text-sm font-bold text-gray-900 mb-2">Permit Details (if required)</label>
            <textarea
                name="permit_details"
                id="permit_details"
                rows="4"
                placeholder="Information about permits..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
            ><?php echo e(old('permit_details')); ?></textarea>
            <?php $__errorArgs = ['permit_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4 pt-4">
            <button
                type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold"
            >
                Create Expedition
            </button>
            <a
                href="<?php echo e(route('admin.expeditions.index')); ?>"
                class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/expeditions/create.blade.php ENDPATH**/ ?>