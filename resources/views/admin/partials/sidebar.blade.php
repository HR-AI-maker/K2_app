<aside class="admin-sidebar" x-data="{
    openMenus: {
        membership: {{ request()->routeIs('admin.members.*') || request()->routeIs('admin.documents.*') ? 'true' : 'false' }},
        events: {{ request()->routeIs('admin.events.*') ? 'true' : 'false' }},
        expeditions: {{ request()->routeIs('admin.expeditions.*') ? 'true' : 'false' }},
        community: {{ request()->routeIs('admin.community.*') || request()->routeIs('admin.badges.*') ? 'true' : 'false' }},
        marketplace: {{ request()->routeIs('admin.vendors.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.orders.*') ? 'true' : 'false' }},
        system: false
    }
}">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link">
            <span class="sidebar-brand-icon">🏔️</span>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">Pak Alpine</span>
                <span class="sidebar-brand-tagline">Admin Portal</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </span>
            <span class="sidebar-item-text">Dashboard</span>
        </a>

        <div class="sidebar-section-title">Apps & Pages</div>

        <!-- Membership -->
        <div class="sidebar-menu">
            <button @click="openMenus.membership = !openMenus.membership" class="sidebar-item" :class="{ 'active': openMenus.membership }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                <span class="sidebar-item-text">Membership</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.membership }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.membership" x-collapse class="sidebar-submenu">
                <a href="{{ route('admin.members.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.members.index') && !request()->has('status') ? 'active' : '' }}">All Members</a>
                <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="sidebar-subitem {{ request()->routeIs('admin.members.index') && request()->get('status') === 'pending' ? 'active' : '' }}">Pending Verification</a>
                <a href="{{ route('admin.documents.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.documents.index') && !request()->has('status') ? 'active' : '' }}">Documents</a>
                <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}" class="sidebar-subitem {{ request()->routeIs('admin.documents.index') && request()->get('status') === 'pending' ? 'active' : '' }}">Pending Review</a>
            </div>
        </div>

        <!-- Events -->
        <div class="sidebar-menu">
            <button @click="openMenus.events = !openMenus.events" class="sidebar-item" :class="{ 'active': openMenus.events }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </span>
                <span class="sidebar-item-text">Events</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.events }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.events" x-collapse class="sidebar-submenu">
                <a href="{{ route('admin.events.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.events.index') ? 'active' : '' }}">All Events</a>
                <a href="{{ route('admin.events.create') }}" class="sidebar-subitem {{ request()->routeIs('admin.events.create') ? 'active' : '' }}">Create Event</a>
                <a href="{{ route('admin.events.index', ['event_type' => 'training']) }}" class="sidebar-subitem">Training Sessions</a>
            </div>
        </div>

        <!-- Expeditions -->
        <div class="sidebar-menu">
            <button @click="openMenus.expeditions = !openMenus.expeditions" class="sidebar-item" :class="{ 'active': openMenus.expeditions }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>
                </span>
                <span class="sidebar-item-text">Expeditions</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.expeditions }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.expeditions" x-collapse class="sidebar-submenu">
                <a href="{{ route('admin.expeditions.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.expeditions.index') ? 'active' : '' }}">All Expeditions</a>
                <a href="{{ route('admin.expeditions.create') }}" class="sidebar-subitem {{ request()->routeIs('admin.expeditions.create') ? 'active' : '' }}">Create Expedition</a>
            </div>
        </div>

        <!-- Community -->
        <div class="sidebar-menu">
            <button @click="openMenus.community = !openMenus.community" class="sidebar-item" :class="{ 'active': openMenus.community }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                </span>
                <span class="sidebar-item-text">Community</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.community }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.community" x-collapse class="sidebar-submenu">
                <a href="{{ route('admin.community.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.community.index') ? 'active' : '' }}">Moderate Posts</a>
                <a href="{{ route('admin.community.index', ['status' => 'draft']) }}" class="sidebar-subitem">Pending Review</a>
                <a href="{{ route('admin.badges.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">Badges</a>
            </div>
        </div>

        <!-- Marketplace -->
        <div class="sidebar-menu">
            <button @click="openMenus.marketplace = !openMenus.marketplace" class="sidebar-item" :class="{ 'active': openMenus.marketplace }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                <span class="sidebar-item-text">Marketplace</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.marketplace }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.marketplace" x-collapse class="sidebar-submenu">
                <a href="{{ route('admin.vendors.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.vendors.index') && !request()->has('status') ? 'active' : '' }}">All Vendors</a>
                <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}" class="sidebar-subitem {{ request()->routeIs('admin.vendors.index') && request()->get('status') === 'pending' ? 'active' : '' }}">Pending Vendors</a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-subitem {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
            </div>
        </div>

        <div class="sidebar-section-title">System</div>

        <!-- System -->
        <div class="sidebar-menu">
            <button @click="openMenus.system = !openMenus.system" class="sidebar-item" :class="{ 'active': openMenus.system }">
                <span class="sidebar-item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </span>
                <span class="sidebar-item-text">Settings</span>
                <span class="sidebar-item-arrow" :class="{ 'rotate-90': openMenus.system }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </button>
            <div x-show="openMenus.system" x-collapse class="sidebar-submenu">
                <a href="#" class="sidebar-subitem">Payments</a>
                <a href="#" class="sidebar-subitem">Reports</a>
                <a href="#" class="sidebar-subitem">General Settings</a>
                <a href="#" class="sidebar-subitem">Audit Logs</a>
            </div>
        </div>

        <!-- Emergency -->
        <a href="#" class="sidebar-item sidebar-item-danger">
            <span class="sidebar-item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </span>
            <span class="sidebar-item-text">Emergency Center</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}</div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->full_name }}</span>
                <span class="sidebar-user-role">Administrator</span>
            </div>
        </div>
    </div>
</aside>
