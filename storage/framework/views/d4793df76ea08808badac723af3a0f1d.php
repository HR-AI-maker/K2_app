

<?php $__env->startSection('title', 'Upload Documents'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?php echo e(route('dashboard')); ?>" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">Upload Documents</h1>
            <p class="text-gray-600 mt-2">Submit required documents for verification</p>
        </div>

        <!-- Upload Form -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-6">📄 Upload New Document</h2>

            <form method="POST" action="<?php echo e(route('profile.documents.upload')); ?>" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Document Type -->
                <div>
                    <label for="document_type" class="block text-sm font-bold text-gray-900 mb-2">Document Type *</label>
                    <select
                        name="document_type"
                        id="document_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-600 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
                        <option value="">Select document type</option>
                        <option value="cnic" <?php echo e(old('document_type') === 'cnic' ? 'selected' : ''); ?>>CNIC / ID Card</option>
                        <option value="passport" <?php echo e(old('document_type') === 'passport' ? 'selected' : ''); ?>>Passport</option>
                        <option value="visa" <?php echo e(old('document_type') === 'visa' ? 'selected' : ''); ?>>Visa</option>
                        <option value="insurance" <?php echo e(old('document_type') === 'insurance' ? 'selected' : ''); ?>>Travel Insurance</option>
                        <option value="medical" <?php echo e(old('document_type') === 'medical' ? 'selected' : ''); ?>>Medical Certificate</option>
                    </select>
                    <?php $__errorArgs = ['document_type'];
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

                <!-- File Upload -->
                <div>
                    <label for="document_file" class="block text-sm font-bold text-gray-900 mb-2">Document File *</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-600 transition"
                         x-data="{ dragover: false }"
                         @dragover.prevent="dragover = true"
                         @dragleave.prevent="dragover = false"
                         @drop.prevent="dragover = false; document.getElementById('document_file').files = $event.dataTransfer.files"
                         :class="{ 'border-blue-600 bg-blue-50': dragover }">
                        <p class="text-4xl mb-2">📤</p>
                        <p class="text-gray-700 font-semibold mb-1">Drag and drop your file here</p>
                        <p class="text-gray-600 text-sm mb-4">or click to select</p>
                        <input
                            type="file"
                            name="document_file"
                            id="document_file"
                            class="hidden"
                            accept=".pdf,.jpg,.jpeg,.png"
                            required
                            @change="document.querySelector('p:last-of-type').textContent = this.files[0]?.name || 'No file selected'"
                        >
                        <button type="button" onclick="document.getElementById('document_file').click()" class="btn-primary">
                            Select File
                        </button>
                        <p class="text-xs text-gray-600 mt-4">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                    <?php $__errorArgs = ['document_file'];
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

                <!-- Submit -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="btn-primary flex-1"
                    >
                        Upload Document
                    </button>
                </div>
            </form>
        </div>

        <!-- Documents List -->
        <div class="card">
            <h2 class="text-2xl font-bold mb-6">📋 Your Documents</h2>

            <?php if($documents->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold capitalize"><?php echo e(str_replace('_', ' ', $document->document_type)); ?></p>
                                    <p class="text-sm text-gray-600">Uploaded <?php echo e($document->created_at->diffForHumans()); ?></p>

                                    <!-- Verification Status -->
                                    <div class="mt-2">
                                        <?php if($document->verified_at): ?>
                                            <span class="badge bg-green-100 text-green-800">
                                                ✓ Verified <?php echo e($document->verified_at->format('M d, Y')); ?>

                                            </span>
                                        <?php elseif($document->rejection_reason): ?>
                                            <span class="badge bg-red-100 text-red-800">
                                                ✗ Rejected
                                            </span>
                                            <?php if($document->rejection_reason): ?>
                                                <p class="text-xs text-red-700 mt-2">
                                                    <strong>Reason:</strong> <?php echo e($document->rejection_reason); ?>

                                                </p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-yellow-100 text-yellow-800">
                                                ⏳ Pending Review
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 ml-4">
                                    <?php if($document->document_url): ?>
                                        <a href="<?php echo e($document->document_url); ?>" target="_blank" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                            View
                                        </a>
                                    <?php endif; ?>
                                    <form method="POST" action="<?php echo e(route('profile.documents.delete', $document)); ?>" class="inline"
                                          onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <p class="text-2xl mb-2">📭</p>
                    <p class="text-gray-600">No documents uploaded yet</p>
                    <p class="text-sm text-gray-500 mt-2">Start by uploading your ID or passport above</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Document Requirements -->
        <div class="mt-8 card bg-blue-50 border-l-4 border-blue-600">
            <h3 class="text-lg font-bold text-blue-900 mb-4">📌 Document Requirements</h3>
            <div class="space-y-3 text-sm text-blue-900">
                <div class="flex items-start gap-2">
                    <span class="text-lg">📇</span>
                    <div>
                        <p class="font-semibold">CNIC / ID Card</p>
                        <p class="text-blue-800">National ID or government-issued ID card</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">🛂</span>
                    <div>
                        <p class="font-semibold">Passport</p>
                        <p class="text-blue-800">Valid passport for international expeditions</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">✈️</span>
                    <div>
                        <p class="font-semibold">Travel Insurance</p>
                        <p class="text-blue-800">Valid travel/mountaineering insurance policy</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">🏥</span>
                    <div>
                        <p class="font-semibold">Medical Certificate</p>
                        <p class="text-blue-800">Medical fitness certificate from a doctor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/profile/documents.blade.php ENDPATH**/ ?>