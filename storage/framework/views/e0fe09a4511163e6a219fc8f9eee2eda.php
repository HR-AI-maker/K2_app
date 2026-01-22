

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
        </div>
        <?php if($errors->any()): ?>
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc list-inside text-red-700 text-sm">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="<?php echo e(route('register')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input id="first_name" name="first_name" type="text" required value="<?php echo e(old('first_name')); ?>" class="mt-1 input">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input id="last_name" name="last_name" type="text" required value="<?php echo e(old('last_name')); ?>" class="mt-1 input">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required value="<?php echo e(old('email')); ?>" class="mt-1 input">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input id="phone" name="phone" type="tel" required value="<?php echo e(old('phone')); ?>" class="mt-1 input">
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address (Optional)</label>
                    <input id="address" name="address" type="text" value="<?php echo e(old('address')); ?>" class="mt-1 input">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required class="mt-1 input">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 input">
                </div>
                <div>
                    <label for="climbing_discipline" class="block text-sm font-medium text-gray-700">Climbing Discipline</label>
                    <select id="climbing_discipline" name="climbing_discipline" required class="mt-1 input">
                        <option value="">Select a discipline</option>
                        <option value="trekking" <?php if(old('climbing_discipline') === 'trekking'): echo 'selected'; endif; ?>>Trekking</option>
                        <option value="rock" <?php if(old('climbing_discipline') === 'rock'): echo 'selected'; endif; ?>>Rock Climbing</option>
                        <option value="ice" <?php if(old('climbing_discipline') === 'ice'): echo 'selected'; endif; ?>>Ice Climbing</option>
                        <option value="mountaineering" <?php if(old('climbing_discipline') === 'mountaineering'): echo 'selected'; endif; ?>>Mountaineering</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Register
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="<?php echo e(route('login')); ?>" class="font-medium text-blue-600 hover:text-blue-500">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\alpine\resources\views/auth/register.blade.php ENDPATH**/ ?>