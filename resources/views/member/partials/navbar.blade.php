<header class="admin-navbar">
    <div class="navbar-left">
        <button class="navbar-toggle md:hidden" @click="sidebarOpen = !sidebarOpen">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <div class="navbar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" placeholder="Search" class="navbar-search-input">
        </div>
    </div>

    <div class="navbar-right">
        <div class="navbar-item" x-data="{ open: false }">
            <button @click="open = !open" class="navbar-user-btn">
                <div class="navbar-user-avatar">{{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}</div>
                <div class="navbar-user-info hidden md:block">
                    <span class="navbar-user-name">{{ auth()->user()->full_name }}</span>
                    <span class="navbar-user-role">Member</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden md:block"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="open" @click.outside="open = false" class="navbar-dropdown navbar-user-dropdown">
                <div class="navbar-user-dropdown-header">
                    <div class="navbar-user-avatar">{{ substr(auth()->user()->first_name, 0, 1) }}{{ substr(auth()->user()->last_name, 0, 1) }}</div>
                    <div>
                        <p class="navbar-user-dropdown-name">{{ auth()->user()->full_name }}</p>
                        <p class="navbar-user-dropdown-email">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="navbar-dropdown-divider"></div>
                <a href="{{ route('home') }}" class="navbar-dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Back to Site
                </a>
                <div class="navbar-dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="navbar-dropdown-item w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
