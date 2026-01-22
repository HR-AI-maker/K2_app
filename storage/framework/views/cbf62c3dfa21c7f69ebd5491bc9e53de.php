<aside class="admin-sidebar" x-data="{
    openMenus: {
        products: <?php echo e(request()->routeIs('vendor.products.*') ? 'true' : 'false'); ?>,
        orders: <?php echo e(request()->routeIs('vendor.orders.*') ? 'true' : 'false'); ?>

    }
}">
    <div class="sidebar-brand">
        <a href="<?php echo e(route('vendor.dashboard')); ?>" class="sidebar-brand-link">
            <span class="sidebar-brand-icon">PA</span>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">Pak Alpine</span>
                <span class="sidebar-brand-tagline">Vendor Portal</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a href="<?php echo e(route('vendor.dashboard')); ?>" class="sidebar-item <?php echo e(request()->routeIs('vendor.dashboard') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </span>
            <span class="sidebar-item-text">Dashboard</span>
        </a>

        <div class="sidebar-section-title">Store</div>

        <div class="sidebar-menu">
            <button @click="openMenus.products = !openMenus.products" class="sidebar-item" :class="{ 'active': openMenus.products }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </span>
                <span class="sidebar-item-text">Products</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.products }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.products" x-collapse class="sidebar-submenu">
                <a href="<?php echo e(route('vendor.products.index')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('vendor.products.index') ? 'active' : ''); ?>">All Products</a>
                <a href="<?php echo e(route('vendor.products.create')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('vendor.products.create') ? 'active' : ''); ?>">Add Product</a>
            </div>
        </div>

        <div class="sidebar-menu">
            <button @click="openMenus.orders = !openMenus.orders" class="sidebar-item" :class="{ 'active': openMenus.orders }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                <span class="sidebar-item-text">Orders</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.orders }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.orders" x-collapse class="sidebar-submenu">
                <a href="<?php echo e(route('vendor.orders.index')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('vendor.orders.index') ? 'active' : ''); ?>">All Orders</a>
            </div>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar"><?php echo e(substr(auth()->user()->first_name, 0, 1)); ?><?php echo e(substr(auth()->user()->last_name, 0, 1)); ?></div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?php echo e(auth()->user()->full_name); ?></span>
                <span class="sidebar-user-role">Vendor</span>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/vendor/partials/sidebar.blade.php ENDPATH**/ ?>