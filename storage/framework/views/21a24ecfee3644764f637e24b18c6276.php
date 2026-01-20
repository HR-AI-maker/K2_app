<nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <div class="flex justify-between items-center gap-4">
            <!-- Logo -->
            <div class="text-2xl font-bold text-blue-600 flex-shrink-0">
                <a href="<?php echo e(route('home')); ?>">Pak Alpine</a>
            </div>

            <!-- Navigation Links -->
            <div class="flex gap-8 flex-1">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Home</a>
                <a href="<?php echo e(route('events.index')); ?>" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Events</a>
                <a href="<?php echo e(route('expeditions.index')); ?>" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Expeditions</a>
                <a href="<?php echo e(route('community.index')); ?>" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Community</a>
                <a href="<?php echo e(route('vendors.index')); ?>" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Vendors</a>
            </div>

            <!-- Search Bar (visible when authenticated) -->
            <?php if(auth()->check()): ?>
                <form method="GET" action="<?php echo e(route('search')); ?>" class="flex-1 max-w-xs">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="q"
                            placeholder="Search..."
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent w-full"
                            value="<?php echo e(request('q')); ?>"
                        >
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                            🔍
                        </button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Right Side (Notifications & Profile) -->
            <div class="flex gap-4 flex-shrink-0 items-center">
                <?php if(auth()->check()): ?>
                    <!-- Notifications Bell -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" class="text-2xl hover:text-blue-600 relative">
                            🔔
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">0</span>
                        </button>
                        <div x-show="notifOpen" @click.outside="notifOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border">
                            <div class="px-4 py-3 border-b font-semibold text-gray-900">Notifications</div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="px-4 py-3 text-gray-500 text-center text-sm">
                                    No new notifications
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            <?php echo e(auth()->user()->first_name); ?>

                        </button>
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow z-50 border">
                        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <a href="<?php echo e(route('profile.medical')); ?>" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 hover:bg-gray-100 font-semibold text-red-600">Admin Panel</a>
                            <hr class="my-2">
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600">Logout</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/partials/navbar.blade.php ENDPATH**/ ?>