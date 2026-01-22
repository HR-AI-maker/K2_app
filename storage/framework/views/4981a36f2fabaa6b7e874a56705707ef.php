<?php $__env->startSection('title', 'Apply - ' . $expedition->title); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-3xl mx-auto px-4">
            <a href="<?php echo e(route('expeditions.show', $expedition)); ?>" class="text-green-100 hover:text-white mb-4 inline-block">
                ← Back to Expedition
            </a>
            <h1 class="text-4xl font-bold mb-2">Apply for Expedition</h1>
            <p class="text-green-100"><?php echo e($expedition->title); ?></p>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="card">
            <h2 class="text-2xl font-bold mb-6">Application Form</h2>

            <form method="POST" action="<?php echo e(route('expeditions.store', $expedition)); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Experience Level -->
                <div>
                    <label for="experience_level" class="block text-sm font-bold text-gray-900 mb-3">
                        Your Experience Level *
                    </label>
                    <div class="space-y-3">
                        <?php $__currentLoopData = ['beginner' => 'Beginner - First time trekking', 'intermediate' => 'Intermediate - Some experience', 'advanced' => 'Advanced - Experienced mountaineer', 'expert' => 'Expert - Professional alpinist']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center cursor-pointer">
                                <input
                                    type="radio"
                                    name="experience_level"
                                    value="<?php echo e($value); ?>"
                                    <?php echo e(old('experience_level') === $value ? 'checked' : ''); ?>

                                    class="w-4 h-4 text-green-600"
                                    required
                                >
                                <span class="ml-3 text-gray-700"><?php echo e($label); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['experience_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Application Notes -->
                <div>
                    <label for="application_notes" class="block text-sm font-bold text-gray-900 mb-2">
                        Tell Us About Yourself *
                    </label>
                    <p class="text-xs text-gray-600 mb-2">
                        Share your mountaineering experience, why you want to join, and any relevant details.
                    </p>
                    <textarea
                        name="application_notes"
                        id="application_notes"
                        rows="6"
                        placeholder="I have been trekking for... I'm interested in this expedition because..."
                        class="input"
                        required
                    ><?php echo e(old('application_notes')); ?></textarea>
                    <?php $__errorArgs = ['application_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Checklist -->
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm font-semibold text-blue-900 mb-3">Before submitting, ensure:</p>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <span class="mr-2">☐</span>
                            <span>Your profile is complete and up-to-date</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">☐</span>
                            <span>You have uploaded all required documents</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">☐</span>
                            <span>Your medical information is current</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">☐</span>
                            <span>You meet the <?php echo e(ucfirst($expedition->difficulty_level)); ?> level requirements</span>
                        </li>
                        <?php if($expedition->permit_required): ?>
                            <li class="flex items-start">
                                <span class="mr-2">☐</span>
                                <span>You are prepared for the permit requirements</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="btn-primary flex-1"
                    >
                        Submit Application
                    </button>
                    <a
                        href="<?php echo e(route('expeditions.show', $expedition)); ?>"
                        class="btn px-6 py-2 bg-gray-600 text-white hover:bg-gray-700 flex items-center justify-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Expedition Summary -->
        <div class="mt-8 card">
            <h3 class="text-xl font-bold mb-4">Expedition Summary</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">LOCATION</p>
                    <p class="font-semibold"><?php echo e($expedition->region); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">DIFFICULTY</p>
                    <p class="font-semibold"><?php echo e(ucfirst($expedition->difficulty_level)); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">START DATE</p>
                    <p class="font-semibold"><?php echo e($expedition->start_date->format('M d, Y')); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">DURATION</p>
                    <p class="font-semibold"><?php echo e($expedition->start_date->diffInDays($expedition->end_date) + 1); ?> days</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/expeditions/apply.blade.php ENDPATH**/ ?>