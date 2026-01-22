<header class="admin-navbar">
    <div class="navbar-left">
        <!-- Sidebar Toggle (Mobile) -->
        <button class="navbar-toggle md:hidden" @click="sidebarOpen = !sidebarOpen">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Search -->
        <div class="navbar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="Search (Ctrl+/)" class="navbar-search-input">
        </div>
    </div>

    <div class="navbar-right">
        <!-- Language Selector -->
        <div class="navbar-item" x-data="{ open: false }">
            <button @click="open = !open" class="navbar-icon-btn">
                <span style="font-size: 1.25rem;">🇺🇸</span>
            </button>
            <div x-show="open" @click.outside="open = false" class="navbar-dropdown" style="width: 140px;">
                <a href="#" class="navbar-dropdown-item active">
                    <span>🇺🇸</span> English
                </a>
                <a href="#" class="navbar-dropdown-item">
                    <span>🇵🇰</span> Urdu
                </a>
            </div>
        </div>

        <!-- Theme Toggle -->
        <button class="navbar-icon-btn" x-data="{ dark: false }" @click="dark = !dark; document.body.classList.toggle('dark-mode')">
            <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
        </button>

        <!-- Shortcuts -->
        <button class="navbar-icon-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        </button>

        <!-- Notifications -->
        <div class="navbar-item" x-data="{ open: false }">
            <button @click="open = !open" class="navbar-icon-btn navbar-notification">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="navbar-notification-badge">8</span>
            </button>
            <div x-show="open" @click.outside="open = false" class="navbar-dropdown navbar-notifications-dropdown">
                <div class="navbar-dropdown-header">
                    <span class="navbar-dropdown-title">Notifications</span>
                    <span class="navbar-dropdown-badge">8 New</span>
                </div>
                <div class="navbar-dropdown-body">
                    <a href="#" class="navbar-notification-item">
                        <div class="navbar-notification-icon primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        </div>
                        <div class="navbar-notification-content">
                            <p class="navbar-notification-text">New member registration</p>
                            <span class="navbar-notification-time">2 min ago</span>
                        </div>
                    </a>
                    <a href="#" class="navbar-notification-item">
                        <div class="navbar-notification-icon warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        </div>
                        <div class="navbar-notification-content">
                            <p class="navbar-notification-text">Document pending review</p>
                            <span class="navbar-notification-time">15 min ago</span>
                        </div>
                    </a>
                    <a href="#" class="navbar-notification-item">
                        <div class="navbar-notification-icon success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                        <div class="navbar-notification-content">
                            <p class="navbar-notification-text">New order received - PKR 12,500</p>
                            <span class="navbar-notification-time">1 hour ago</span>
                        </div>
                    </a>
                </div>
                <a href="#" class="navbar-dropdown-footer">View all notifications</a>
            </div>
        </div>

        <!-- User Menu -->
        <div class="navbar-item" x-data="{ open: false }">
            <button @click="open = !open" class="navbar-user-btn">
                <div class="navbar-user-avatar"><?php echo e(substr(auth()->user()->first_name, 0, 1)); ?><?php echo e(substr(auth()->user()->last_name, 0, 1)); ?></div>
                <div class="navbar-user-info hidden md:block">
                    <span class="navbar-user-name"><?php echo e(auth()->user()->full_name); ?></span>
                    <span class="navbar-user-role">Admin</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden md:block"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="open" @click.outside="open = false" class="navbar-dropdown navbar-user-dropdown">
                <div class="navbar-user-dropdown-header">
                    <div class="navbar-user-avatar lg"><?php echo e(substr(auth()->user()->first_name, 0, 1)); ?><?php echo e(substr(auth()->user()->last_name, 0, 1)); ?></div>
                    <div>
                        <p class="navbar-user-dropdown-name"><?php echo e(auth()->user()->full_name); ?></p>
                        <p class="navbar-user-dropdown-email"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>
                <div class="navbar-dropdown-divider"></div>
                <a href="#" class="navbar-dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    My Profile
                </a>
                <a href="#" class="navbar-dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Settings
                </a>
                <a href="<?php echo e(route('home')); ?>" class="navbar-dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Back to Site
                </a>
                <div class="navbar-dropdown-divider"></div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="navbar-dropdown-item navbar-dropdown-item-danger w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/admin/partials/navbar.blade.php ENDPATH**/ ?>