<!-- UI change only – no logic modified -->
<nav class="navbar">
    <div class="navbar-content">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-logo">
            🏔️ Pak Alpine
        </a>

        <!-- Navigation Links (authenticated users only) -->
        @if (auth()->check())
        <div class="navbar-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
            <a href="{{ route('expeditions.index') }}" class="{{ request()->routeIs('expeditions.*') ? 'active' : '' }}">Expeditions</a>
            <a href="{{ route('community.index') }}" class="{{ request()->routeIs('community.*') ? 'active' : '' }}">Community</a>
            <a href="{{ route('vendors.index') }}" class="{{ request()->routeIs('vendors.*') ? 'active' : '' }}">Vendors</a>
            <a href="{{ route('marketplace.index') }}" class="{{ request()->routeIs('marketplace.*') ? 'active' : '' }}">Marketplace</a>
        </div>
        @endif

        <!-- Search Bar (authenticated users only) -->
        @if (auth()->check())
        <form method="GET" action="{{ route('search') }}" class="navbar-search">
            <input
                type="text"
                name="q"
                placeholder="Search..."
                class="navbar-search-input"
                value="{{ request('q') }}"
                minlength="2"
            >
        </form>
        @endif

        <!-- Right Side Actions -->
        <div class="navbar-actions">
            @if (auth()->check())
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="navbar-icon-btn" title="Shopping Cart">
                    🛒
                    @if (auth()->user()->cartItems->count() > 0)
                        <span class="navbar-badge">{{ auth()->user()->cartItems->sum('quantity') }}</span>
                    @endif
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
                        <span>{{ auth()->user()->first_name }}</span>
                        <span>▼</span>
                    </button>
                    <div
                        x-show="profileOpen"
                        @click.outside="profileOpen = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 border border-gray-200"
                        style="display: none;"
                    >
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">Profile</a>
                        <a href="{{ route('profile.medical') }}" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">Settings</a>
                        <a href="{{ route('orders.index') }}" class="block px-4 py-3 hover:bg-gray-50 text-gray-700 font-medium">My Orders</a>
                        @if (auth()->user()->isVendor())
                            <hr class="my-1">
                            <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-3 hover:bg-gray-50 text-primary font-semibold">Vendor Dashboard</a>
                        @endif
                        @if (auth()->user()->isAdmin())
                            <hr class="my-1">
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-gray-50 text-danger font-semibold">Admin Panel</a>
                        @endif
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 text-danger font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Unauthenticated Actions -->
                <a href="{{ route('login') }}" class="btn btn-outline btn-md">Sign In</a>
                <a href="{{ route('member.register') }}" class="btn btn-primary btn-md">Join Now</a>
            @endif
        </div>
    </div>
</nav>
