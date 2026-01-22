<aside class="w-64 bg-gray-800 text-white p-4 h-screen overflow-y-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold">Pak Alpine</h2>
        <p class="text-sm text-gray-400">Admin Panel</p>
    </div>

    <nav class="space-y-2">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 rounded <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700'); ?>">
            📊 Dashboard
        </a>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">MEMBERSHIP</p>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 @active(Route::currentRouteName() === 'admin.members.index' || Route::currentRouteName() === 'admin.members.show')">👥 Manage Members</a>
            <a href="<?php echo e(route('admin.members.index', ['status' => 'pending'])); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">✓ Pending Verification</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📋 Membership Tiers</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">VERIFICATION</p>
            <a href="<?php echo e(route('admin.documents.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.documents.*') ? 'bg-blue-600' : ''); ?>">📄 Documents</a>
            <a href="<?php echo e(route('admin.documents.index', ['status' => 'pending'])); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">⏳ Pending Review</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">EVENTS</p>
            <a href="<?php echo e(route('admin.events.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.events.*') ? 'bg-blue-600' : ''); ?>">📅 All Events</a>
            <a href="<?php echo e(route('admin.events.create')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">➕ Create Event</a>
            <a href="<?php echo e(route('admin.events.index', ['event_type' => 'training'])); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">🎓 Trainings</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">EXPEDITIONS</p>
            <a href="<?php echo e(route('admin.expeditions.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.expeditions.*') ? 'bg-blue-600' : ''); ?>">🏔️ All Expeditions</a>
            <a href="<?php echo e(route('admin.expeditions.create')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">➕ Create Expedition</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">SAFETY & RESCUE</p>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">🚨 Emergency Reports</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">🗺️ Trip Records</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">⚠️ Hazard Alerts</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">COMMUNITY</p>
            <a href="<?php echo e(route('admin.community.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.community.*') ? 'bg-blue-600' : ''); ?>">📢 Moderate Posts</a>
            <a href="<?php echo e(route('admin.community.index', ['status' => 'draft'])); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">⏳ Pending Review</a>
            <a href="<?php echo e(route('admin.badges.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.badges.*') ? 'bg-blue-600' : ''); ?>">🏆 Badges</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">MARKETPLACE</p>
            <a href="<?php echo e(route('admin.vendors.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.vendors.*') ? 'bg-blue-600' : ''); ?>">🏪 Vendors</a>
            <a href="<?php echo e(route('admin.vendors.index', ['status' => 'pending'])); ?>" class="block px-4 py-2 rounded hover:bg-gray-700">⏳ Pending Vendors</a>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.products.*') ? 'bg-blue-600' : ''); ?>">📦 Product Moderation</a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="block px-4 py-2 rounded hover:bg-gray-700 <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-blue-600' : ''); ?>">🛒 Orders</a>
        </div>

        <div class="mt-6">
            <p class="px-4 py-2 text-gray-400 font-semibold text-sm">SYSTEM</p>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">💰 Payments</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📊 Reports</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">⚙️ Settings</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📝 Audit Logs</a>
        </div>
    </nav>
</aside>
<?php /**PATH C:\Users\lenovo\Desktop\K2\K2_App\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>