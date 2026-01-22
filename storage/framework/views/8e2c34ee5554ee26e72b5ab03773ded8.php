<aside class="admin-sidebar" x-data="{
    openMenus: {
        account: <?php echo e(request()->routeIs('profile.*') ? 'true' : 'false'); ?>

    }
}">
    <div class="sidebar-brand">
        <a href="<?php echo e(route('member.dashboard')); ?>" class="sidebar-brand-link">
            <span class="sidebar-brand-icon">PA</span>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">Pak Alpine</span>
                <span class="sidebar-brand-tagline">Member Portal</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a href="<?php echo e(route('member.dashboard')); ?>" class="sidebar-item <?php echo e(request()->routeIs('member.dashboard') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </span>
            <span class="sidebar-item-text">Dashboard</span>
        </a>

        <div class="sidebar-section-title">Marketplace</div>

        <a href="<?php echo e(route('marketplace.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('marketplace.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </span>
            <span class="sidebar-item-text">Marketplace</span>
        </a>

        <a href="<?php echo e(route('orders.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('orders.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </span>
            <span class="sidebar-item-text">Orders</span>
        </a>

        <a href="<?php echo e(route('cart.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('cart.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </span>
            <span class="sidebar-item-text">Cart</span>
        </a>

        <div class="sidebar-section-title">Explore</div>

        <a href="<?php echo e(route('events.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('events.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </span>
            <span class="sidebar-item-text">Events</span>
        </a>

        <a href="<?php echo e(route('expeditions.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('expeditions.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>
            </span>
            <span class="sidebar-item-text">Expeditions</span>
        </a>

        <a href="<?php echo e(route('community.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('community.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            </span>
            <span class="sidebar-item-text">Community</span>
        </a>

        <a href="<?php echo e(route('vendors.index')); ?>" class="sidebar-item <?php echo e(request()->routeIs('vendors.*') ? 'active' : ''); ?>">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M5 21V7l8-4 8 4v14"></path><path d="M9 21v-6h6v6"></path></svg>
            </span>
            <span class="sidebar-item-text">Vendors</span>
        </a>

        <div class="sidebar-section-title">Account</div>

        <div class="sidebar-menu">
            <button @click="openMenus.account = !openMenus.account" class="sidebar-item" :class="{ 'active': openMenus.account }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </span>
                <span class="sidebar-item-text">Profile</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.account }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.account" x-collapse class="sidebar-submenu">
                <a href="<?php echo e(route('profile.edit')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>">Profile</a>
                <a href="<?php echo e(route('profile.membership')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('profile.membership') ? 'active' : ''); ?>">Membership</a>
                <a href="<?php echo e(route('profile.documents')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('profile.documents') ? 'active' : ''); ?>">Documents</a>
                <a href="<?php echo e(route('profile.medical')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('profile.medical') ? 'active' : ''); ?>">Medical</a>
                <a href="<?php echo e(route('profile.badges')); ?>" class="sidebar-subitem <?php echo e(request()->routeIs('profile.badges') ? 'active' : ''); ?>">Badges</a>
            </div>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar"><?php echo e(substr(auth()->user()->first_name, 0, 1)); ?><?php echo e(substr(auth()->user()->last_name, 0, 1)); ?></div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?php echo e(auth()->user()->full_name); ?></span>
                <span class="sidebar-user-role">Member</span>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/member/partials/sidebar.blade.php ENDPATH**/ ?>