<?php $__env->startSection('title', 'Edit Vendor: ' . $vendor->business_name); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Vendor
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Edit Vendor</h1>
    <p class="text-gray-600 mt-2"><?php echo e($vendor->business_name); ?></p>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <form method="POST" action="<?php echo e(route('admin.vendors.update', $vendor)); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Business Name -->
            <div>
                <label for="business_name" class="block text-sm font-semibold text-gray-900 mb-2">
                    Business Name *
                </label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    value="<?php echo e(old('business_name', $vendor->business_name)); ?>"
                    class="input <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['business_name'];
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

            <!-- Contact Person -->
            <div>
                <label for="contact_person" class="block text-sm font-semibold text-gray-900 mb-2">
                    Contact Person *
                </label>
                <input
                    type="text"
                    id="contact_person"
                    name="contact_person"
                    value="<?php echo e(old('contact_person', $vendor->contact_person)); ?>"
                    class="input <?php $__errorArgs = ['contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['contact_person'];
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

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                    Email *
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo e(old('email', $vendor->email)); ?>"
                    class="input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['email'];
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

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                    Phone *
                </label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="<?php echo e(old('phone', $vendor->phone)); ?>"
                    class="input <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                <?php $__errorArgs = ['phone'];
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

            <!-- Business Type -->
            <div>
                <label for="business_type" class="block text-sm font-semibold text-gray-900 mb-2">
                    Business Type *
                </label>
                <select
                    id="business_type"
                    name="business_type"
                    class="input <?php $__errorArgs = ['business_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    required
                >
                    <option value="guide" <?php echo e(old('business_type', $vendor->business_type) === 'guide' ? 'selected' : ''); ?>>Guide</option>
                    <option value="transport" <?php echo e(old('business_type', $vendor->business_type) === 'transport' ? 'selected' : ''); ?>>Transport</option>
                    <option value="lodging" <?php echo e(old('business_type', $vendor->business_type) === 'lodging' ? 'selected' : ''); ?>>Lodging</option>
                    <option value="equipment" <?php echo e(old('business_type', $vendor->business_type) === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                    <option value="other" <?php echo e(old('business_type', $vendor->business_type) === 'other' ? 'selected' : ''); ?>>Other</option>
                </select>
                <?php $__errorArgs = ['business_type'];
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

            <!-- Certification Status -->
            <div class="flex items-center">
                <label for="is_certified" class="flex items-center">
                    <input
                        type="checkbox"
                        id="is_certified"
                        name="is_certified"
                        value="1"
                        <?php echo e(old('is_certified', $vendor->is_certified) ? 'checked' : ''); ?>

                        class="rounded"
                    >
                    <span class="ml-2 text-sm font-semibold text-gray-900">Certified Vendor</span>
                </label>
            </div>
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">
                Address *
            </label>
            <input
                type="text"
                id="address"
                name="address"
                value="<?php echo e(old('address', $vendor->address)); ?>"
                placeholder="City, Region, Country"
                class="input <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required
            >
            <?php $__errorArgs = ['address'];
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

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                Description *
            </label>
            <textarea
                id="description"
                name="description"
                rows="6"
                placeholder="Describe the vendor's services, experience, and specialties..."
                class="input <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required
            ><?php echo e(old('description', $vendor->description)); ?></textarea>
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

        <!-- Certification Details -->
        <div>
            <label for="certification_details" class="block text-sm font-semibold text-gray-900 mb-2">
                Certification Details (Optional)
            </label>
            <textarea
                id="certification_details"
                name="certification_details"
                rows="4"
                placeholder="List certifications, licenses, or credentials..."
                class="input <?php $__errorArgs = ['certification_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            ><?php echo e(old('certification_details', $vendor->certification_details)); ?></textarea>
            <?php $__errorArgs = ['certification_details'];
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

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="btn-primary flex-1">
                ✓ Update Vendor
            </button>
            <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="btn-secondary flex-1">
                Cancel
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/vendors/edit.blade.php ENDPATH**/ ?>