<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Pak Alpine')); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge {
            @apply px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full;
        }
        .btn {
            @apply px-4 py-2 rounded-lg font-semibold transition-colors;
        }
        .btn-primary {
            @apply btn bg-blue-600 text-white hover:bg-blue-700;
        }
        .input {
            @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600;
        }
        .card {
            @apply bg-white p-6 rounded-lg shadow;
        }
    </style>
</head>
<body class="bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/layouts/app.blade.php ENDPATH**/ ?>