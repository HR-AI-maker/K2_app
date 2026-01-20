<div class="bg-white border-b p-4 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
    </div>

    <div class="flex items-center gap-6">
        <!-- Search -->
        <input type="text" placeholder="Search..." class="px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-600">

        <!-- Notifications -->
        <button class="relative text-gray-600 hover:text-gray-900">
            🔔
            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
        </button>

        <!-- User Menu -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100">
                <span>{{ auth()->user()->first_name }}</span>
                <span>▼</span>
            </button>
            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow z-50 border">
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-gray-100">Back to Site</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
