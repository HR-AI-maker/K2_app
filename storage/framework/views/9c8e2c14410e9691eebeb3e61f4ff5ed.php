

<?php $__env->startSection('title', 'Document Verification'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">📄 Document Verification</h1>
            <p class="text-gray-600 mt-2">Review and verify user-submitted documents</p>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'verified' ? 'ring-2 ring-green-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Verified</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['verified']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'rejected' ? 'ring-2 ring-red-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Rejected</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['rejected']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.documents.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="pending" <?php echo e($currentStatus === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="verified" <?php echo e($currentStatus === 'verified' ? 'selected' : ''); ?>>Verified</option>
                    <option value="rejected" <?php echo e($currentStatus === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    <option value="all" <?php echo e($currentStatus === 'all' ? 'selected' : ''); ?>>All</option>
                </select>
            </div>

            <!-- Document Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                <select name="document_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="cnic" <?php echo e(request('document_type') === 'cnic' ? 'selected' : ''); ?>>CNIC</option>
                    <option value="passport" <?php echo e(request('document_type') === 'passport' ? 'selected' : ''); ?>>Passport</option>
                    <option value="visa" <?php echo e(request('document_type') === 'visa' ? 'selected' : ''); ?>>Visa</option>
                    <option value="insurance" <?php echo e(request('document_type') === 'insurance' ? 'selected' : ''); ?>>Insurance</option>
                    <option value="medical" <?php echo e(request('document_type') === 'medical' ? 'selected' : ''); ?>>Medical</option>
                </select>
            </div>

            <!-- Search by User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search User</label>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Email, name..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                    <option value="updated_at" <?php echo e(request('sort_by') === 'updated_at' ? 'selected' : ''); ?>>Recently Updated</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Documents Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if($documents->count() > 0): ?>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Document Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uploaded</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Verified By</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold"><?php echo e($document->user->full_name); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e($document->user->email); ?></p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm capitalize">
                            <span class="badge bg-blue-100 text-blue-800">
                                <?php echo e(str_replace('_', ' ', $document->document_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php echo e($document->created_at->format('M d, Y')); ?><br>
                            <span class="text-gray-600"><?php echo e($document->created_at->diffForHumans()); ?></span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($document->verified_at): ?>
                                <span class="badge bg-green-100 text-green-800">
                                    ✓ Verified
                                </span>
                            <?php elseif($document->rejection_date): ?>
                                <span class="badge bg-red-100 text-red-800">
                                    ✗ Rejected
                                </span>
                            <?php else: ?>
                                <span class="badge bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($document->verifiedBy): ?>
                                <p class="text-sm"><?php echo e($document->verifiedBy->full_name); ?></p>
                                <p class="text-gray-600"><?php echo e($document->verified_at->format('M d, Y')); ?></p>
                            <?php else: ?>
                                <span class="text-gray-500">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <a href="<?php echo e(route('admin.documents.show', $document)); ?>" class="text-blue-600 hover:underline">
                                Review
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No documents found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see documents</p>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($documents->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/documents/index.blade.php ENDPATH**/ ?>