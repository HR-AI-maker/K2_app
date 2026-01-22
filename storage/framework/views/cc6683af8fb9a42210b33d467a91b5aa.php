

<?php $__env->startSection('title', 'Community Moderation'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">💬 Community Moderation</h1>
            <p class="text-gray-600 mt-2">Review and moderate user-created posts</p>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'draft' ? 'ring-2 ring-yellow-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['draft']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'published' ? 'ring-2 ring-green-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['published']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center <?php echo e($currentStatus === 'hidden' ? 'ring-2 ring-red-600' : ''); ?>">
        <p class="text-gray-600 text-sm">Hidden</p>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['hidden']); ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total']); ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="<?php echo e(route('admin.community.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="draft" <?php echo e($currentStatus === 'draft' ? 'selected' : ''); ?>>Pending</option>
                    <option value="published" <?php echo e($currentStatus === 'published' ? 'selected' : ''); ?>>Published</option>
                    <option value="hidden" <?php echo e($currentStatus === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                    <option value="all" <?php echo e($currentStatus === 'all' ? 'selected' : ''); ?>>All</option>
                </select>
            </div>

            <!-- Post Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                <select name="post_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="post" <?php echo e($currentPostType === 'post' ? 'selected' : ''); ?>>Post</option>
                    <option value="journal" <?php echo e($currentPostType === 'journal' ? 'selected' : ''); ?>>Journal</option>
                    <option value="photo" <?php echo e($currentPostType === 'photo' ? 'selected' : ''); ?>>Photo</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Title, author, region..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                    <option value="likes_count" <?php echo e(request('sort_by') === 'likes_count' ? 'selected' : ''); ?>>Most Popular</option>
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

<!-- Posts Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if($posts->count() > 0): ?>
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Author</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Region</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Created</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold line-clamp-1 max-w-xs"><?php echo e($post->title); ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-sm"><?php echo e($post->user->full_name); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e($post->user->email); ?></p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="badge
                                <?php if($post->post_type === 'post'): ?> bg-blue-100 text-blue-800
                                <?php elseif($post->post_type === 'journal'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-orange-100 text-orange-800
                                <?php endif; ?>">
                                <?php if($post->post_type === 'post'): ?> Post
                                <?php elseif($post->post_type === 'journal'): ?> Journal
                                <?php else: ?> Photo
                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php echo e($post->region); ?>

                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($post->status === 'draft'): ?>
                                <span class="badge bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                            <?php elseif($post->status === 'published' || $post->status === 'approved'): ?>
                                <span class="badge bg-green-100 text-green-800">
                                    ✓ Published
                                </span>
                            <?php elseif($post->status === 'hidden'): ?>
                                <span class="badge bg-red-100 text-red-800">
                                    ✗ Hidden
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php echo e($post->created_at->format('M d, Y')); ?><br>
                            <span class="text-gray-600"><?php echo e($post->created_at->diffForHumans()); ?></span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            <?php if($post->status === 'draft'): ?>
                                <form method="POST" action="<?php echo e(route('admin.community.approve', $post)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full text-center">
                                        Approve
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if($post->status !== 'hidden'): ?>
                                <form method="POST" action="<?php echo e(route('admin.community.hide', $post)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 block w-full text-center">
                                        Hide
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('admin.community.unhide', $post)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 block w-full text-center">
                                        Unhide
                                    </button>
                                </form>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo e(route('admin.community.destroy', $post)); ?>" onsubmit="return confirm('Delete this post?');" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-800 block w-full text-center">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No posts found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see posts</p>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?php echo e($posts->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/community/index.blade.php ENDPATH**/ ?>