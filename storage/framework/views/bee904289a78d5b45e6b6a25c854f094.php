<?php $__env->startSection('title', 'Welcome'); ?>

<?php $__env->startSection('content'); ?>
<div class="hero bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Pak Alpine</h1>
        <p class="text-xl mb-8">Connect • Train • Explore • Share</p>
        <p class="text-lg mb-8">Digital Ecosystem for Alpine Club of Pakistan</p>

        <?php if(!auth()->check()): ?>
            <div class="flex gap-4 justify-center">
                <a href="<?php echo e(route('login')); ?>" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Sign In
                </a>
                <a href="<?php echo e(route('register')); ?>" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition">
                    Register
                </a>
            </div>
        <?php else: ?>
            <div class="flex gap-4 justify-center">
                <a href="<?php echo e(route('dashboard')); ?>" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Go to Dashboard
                </a>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition">
                        Admin Panel
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Explore Expeditions -->
        <a href="<?php echo e(route('expeditions.index')); ?>" class="p-6 border rounded-lg hover:shadow-lg hover:border-blue-500 transition cursor-pointer bg-white hover:bg-blue-50">
            <h3 class="text-2xl font-bold mb-2">🏔️ Explore</h3>
            <p class="text-gray-600">Discover mountains and expeditions across Pakistan</p>
            <div class="mt-4 text-blue-600 font-semibold">Browse Expeditions →</div>
        </a>

        <!-- Train with Guides -->
        <a href="<?php echo e(route('vendors.index')); ?>" class="p-6 border rounded-lg hover:shadow-lg hover:border-green-500 transition cursor-pointer bg-white hover:bg-green-50">
            <h3 class="text-2xl font-bold mb-2">📚 Train</h3>
            <p class="text-gray-600">Learn from certified guides and mentors</p>
            <div class="mt-4 text-green-600 font-semibold">View Guides →</div>
        </a>

        <!-- Connect Community -->
        <a href="<?php echo e(route('community.index')); ?>" class="p-6 border rounded-lg hover:shadow-lg hover:border-purple-500 transition cursor-pointer bg-white hover:bg-purple-50">
            <h3 class="text-2xl font-bold mb-2">🤝 Connect</h3>
            <p class="text-gray-600">Join our community of climbers and trekkers</p>
            <div class="mt-4 text-purple-600 font-semibold">Join Community →</div>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/welcome.blade.php ENDPATH**/ ?>