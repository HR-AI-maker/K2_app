<!-- UI change only – no logic modified -->
<nav class="navbar">
    <div class="navbar-content">
        <!-- Logo -->
        <a href="<?php echo e(route('home')); ?>" class="navbar-logo">
            🏔️ Pak Alpine
        </a>

        <!-- Navigation Links (authenticated users only) -->
        <?php if(auth()->check()): ?>
        <div class="navbar-links">
            <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a>
            <a href="<?php echo e(route('events.index')); ?>" class="<?php echo e(request()->routeIs('events.*') ? 'active' : ''); ?>">Events</a>
            <a href="<?php echo e(route('expeditions.index')); ?>" class="<?php echo e(request()->routeIs('expeditions.*') ? 'active' : ''); ?>">Expeditions</a>
            <a href="<?php echo e(route('community.index')); ?>" class="<?php echo e(request()->routeIs('community.*') ? 'active' : ''); ?>">Community</a>
            <a href="<?php echo e(route('vendors.index')); ?>" class="<?php echo e(request()->routeIs('vendors.*') ? 'active' : ''); ?>">Vendors</a>
            <a href="<?php echo e(route('marketplace.index')); ?>" class="<?php echo e(request()->routeIs('marketplace.*') ? 'active' : ''); ?>">Marketplace</a>
        </div>
        <?php endif; ?>

        <!-- Search Bar (authenticated users only) -->
        <?php if(auth()->check()): ?>
        <form method="GET" action="<?php echo e(route('search')); ?>" class="navbar-search">
            <input
                type="text"
                name="q"
                placeholder="Search..."
                class="navbar-search-input"
                value="<?php echo e(request('q')); ?>"
                minlength="2"
            >
        </form>
        <?php endif; ?>

        <!-- Right Side Actions -->
        <div class="navbar-actions">
            <?php if(auth()->check()): ?>
                <!-- Cart Icon -->
                <a href="<?php echo e(route('cart.index')); ?>" class="navbar-icon-btn" title="Shopping Cart">
                    🛒
                    <?php if(auth()->user()->cartItems->count() > 0): ?>
                        <span class="navbar-badge"><?php echo e(auth()->user()->cartItems->sum('quantity')); ?></span>
                    <?php endif; ?>
                </a>

                <!-- Notifications Bell -->
                <div x-data="{ notifOpen: false }" class="relative">
                    <button
                        @click="notifOpen = !notifOpen"
                        class="navbar-icon-btn"
                        title="Notifications"
                        aria-label="Notifications"
                    >
                        🔔
                        <span class="navbar-badge">0</span>
                    </button>
                    <div
                        x-show="notifOpen"
                        @click.outside="notifOpen = false"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-200"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b border-gray-200 font-semibold text-gray-900">Notifications</div>
                        <div class="max-h-96 overflow-y-auto">
                            <div class="px-4 py-3 text-gray-500 text-center text-sm">
                                No new notifications
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div x-data="{ profileOpen: false }" class="relative">
                    <button
                        @click="profileOpen = !profileOpen"
                        class="navbar-user-btn"
                        aria-label="User Menu"
                    >
                        <span><?php echo e(auth()->user()->first_name); ?></span>
                        <span>▼</span>
                    </button>
                    <div
                        x-show="profileOpen"
                        @click.outside="profileOpen = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 border border-gray-200"
                        style="display: none;"
                    >
                        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">Profile</a>
                        <a href="<?php echo e(route('profile.medical')); ?>" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">Settings</a>
                        <a href="<?php echo e(route('orders.index')); ?>" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">My Orders</a>
                        <?php if(auth()->user()->isVendor()): ?>
                            <hr class="my-1">
                            <a href="<?php echo e(route('vendor.dashboard')); ?>" class="block px-4 py-3 hover:bg-gray-50 text-primary font-semibold">Vendor Dashboard</a>
                        <?php endif; ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <hr class="my-1">
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-3 hover:bg-gray-50 text-danger font-semibold">Admin Panel</a>
                        <?php endif; ?>
                        <hr class="my-1">
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 text-danger font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Unauthenticated Actions -->
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline btn-md">Sign In</a>
                <a href="<?php echo e(route('member.register')); ?>" class="btn btn-primary btn-md">Join Now</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/partials/navbar.blade.php ENDPATH**/ ?>