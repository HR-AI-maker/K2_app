

<?php $__env->startSection('title', 'Community Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Community Posts</h1>
                    <p class="text-purple-100">Share your alpine experiences and connect with fellow climbers</p>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('community.create')); ?>" class="btn-primary">
                        ✍️ Write a Post
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-primary">
                        ✍️ Login to Write
                    </a>
                <?php endif; ?>
            </div>
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
                        placeholder="Title, content..."
                        class="input"
                    >
                </div>

                <!-- Post Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="post_type" class="input">
                        <option value="">All Types</option>
                        <option value="post" <?php echo e($currentPostType === 'post' ? 'selected' : ''); ?>>Post</option>
                        <option value="journal" <?php echo e($currentPostType === 'journal' ? 'selected' : ''); ?>>Journal</option>
                        <option value="photo" <?php echo e($currentPostType === 'photo' ? 'selected' : ''); ?>>Photo</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region); ?>" <?php echo e($currentRegion === $region ? 'selected' : ''); ?>>
                                <?php echo e($region); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                    <select name="sort_by" class="input">
                        <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Newest</option>
                        <option value="likes_count" <?php echo e(request('sort_by') === 'likes_count' ? 'selected' : ''); ?>>Most Popular</option>
                        <option value="comments_count" <?php echo e(request('sort_by') === 'comments_count' ? 'selected' : ''); ?>>Most Discussed</option>
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

        <!-- Posts Grid -->
        <?php if($posts->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('community.show', $post)); ?>" class="card hover:shadow-lg transition-shadow hover:scale-105">
                        <!-- Post Type Badge & Author -->
                        <div class="flex justify-between items-start mb-3">
                            <span class="badge
                                <?php if($post->post_type === 'post'): ?> bg-blue-100 text-blue-800
                                <?php elseif($post->post_type === 'journal'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-orange-100 text-orange-800
                                <?php endif; ?>">
                                <?php if($post->post_type === 'post'): ?> 📝 Post
                                <?php elseif($post->post_type === 'journal'): ?> 📖 Journal
                                <?php else: ?> 📷 Photo
                                <?php endif; ?>
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            <?php echo e($post->title); ?>

                        </h3>

                        <!-- Region -->
                        <p class="text-sm text-gray-600 mb-2">
                            📍 <?php echo e($post->region); ?>

                        </p>

                        <!-- Content Preview -->
                        <p class="text-sm text-gray-700 mb-3 line-clamp-3">
                            <?php echo e($post->content); ?>

                        </p>

                        <!-- Author & Date -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                                <div class="text-xs">
                                    <p class="font-semibold text-gray-900"><?php echo e($post->user->first_name); ?></p>
                                    <p class="text-gray-600"><?php echo e($post->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Engagement Stats -->
                        <div class="flex gap-4 mt-3 pt-3 border-t border-gray-200 text-sm text-gray-600">
                            <span>👍 <?php echo e($post->likes_count ?? 0); ?></span>
                            <span>💬 <?php echo e($post->comments_count ?? 0); ?></span>
                        </div>

                        <!-- Approval Badge -->
                        <?php if($post->status === 'draft'): ?>
                            <div class="mt-3 p-2 bg-yellow-100 rounded text-xs text-yellow-800 font-semibold">
                                ⏳ Pending Approval
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                <?php echo e($posts->links()); ?>

            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-6xl mb-4">📭</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Posts Found</h3>
                <p class="text-gray-600 mb-6">Be the first to share your alpine adventure!</p>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('community.create')); ?>" class="btn-primary">
                        ✍️ Create a Post
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-primary">
                        Login to Share
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/community/index.blade.php ENDPATH**/ ?>