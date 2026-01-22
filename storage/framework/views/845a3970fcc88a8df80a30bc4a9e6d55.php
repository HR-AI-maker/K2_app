<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Pak Alpine')); ?> - Admin <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js Library for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary: #7367f0;
            --primary-dark: #5e50ee;
            --primary-light: #9e95f5;
            --secondary: #82868b;
            --success: #28c76f;
            --danger: #ea5455;
            --warning: #ff9f43;
            --info: #00cfe8;
            --dark: #4b4b4b;
            --light: #f8f8f8;
            --body-bg: #f8f8f8;
            --card-bg: #ffffff;
            --border-color: #ebe9f1;
            --text-primary: #5e5873;
            --text-secondary: #6e6b7b;
            --text-muted: #b9b9c3;
            --sidebar-bg: #283046;
            --sidebar-text: #d0d2d6;
            --sidebar-active: var(--primary);
        }

        * { box-sizing: border-box; }
        body {
            background: var(--body-bg);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Admin Sidebar */
        .admin-sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            font-size: 2rem;
        }

        .sidebar-brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            display: block;
        }

        .sidebar-brand-tagline {
            font-size: 0.7rem;
            color: var(--sidebar-text);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .sidebar-section-title {
            padding: 1.5rem 1.25rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 0.9375rem;
        }

        .sidebar-item:hover {
            color: white;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-item.active {
            color: white;
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
            box-shadow: 0 0 10px 1px rgba(115,103,240,0.7);
            border-radius: 0.375rem;
            margin: 0 0.75rem;
            width: calc(100% - 1.5rem);
        }

        .sidebar-item-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-item-arrow {
            margin-left: auto;
            transition: transform 0.2s ease;
        }

        .sidebar-item-arrow.rotate-90 {
            transform: rotate(90deg);
        }

        .sidebar-submenu {
            padding-left: 2.5rem;
        }

        .sidebar-subitem {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-subitem::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            border: 1px solid var(--sidebar-text);
        }

        .sidebar-subitem:hover, .sidebar-subitem.active {
            color: var(--primary);
        }

        .sidebar-subitem.active::before {
            background: var(--primary);
            border-color: var(--primary);
        }

        .sidebar-item-danger {
            color: var(--danger) !important;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .sidebar-user-name {
            display: block;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: var(--sidebar-text);
        }

        /* Admin Navbar */
        .admin-navbar {
            background: var(--card-bg);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-left, .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--light);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
        }

        .navbar-search svg {
            color: var(--text-muted);
        }

        .navbar-search-input {
            border: none;
            background: transparent;
            outline: none;
            width: 200px;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .navbar-icon-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .navbar-icon-btn:hover {
            background: var(--light);
            color: var(--primary);
        }

        .navbar-notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--danger);
            color: white;
            font-size: 0.625rem;
            font-weight: 600;
            padding: 0.125rem 0.375rem;
            border-radius: 9999px;
            min-width: 18px;
            text-align: center;
        }

        .navbar-item {
            position: relative;
        }

        .navbar-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: var(--card-bg);
            border-radius: 0.5rem;
            box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1);
            border: 1px solid var(--border-color);
            min-width: 200px;
            z-index: 100;
            overflow: hidden;
        }

        .navbar-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-dropdown-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .navbar-dropdown-badge {
            background: rgba(115,103,240,0.12);
            color: var(--primary);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .navbar-dropdown-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .navbar-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .navbar-dropdown-item:hover {
            background: var(--light);
            color: var(--primary);
        }

        .navbar-dropdown-item-danger {
            color: var(--danger) !important;
        }

        .navbar-dropdown-divider {
            border-top: 1px solid var(--border-color);
            margin: 0.5rem 0;
        }

        .navbar-dropdown-footer {
            display: block;
            padding: 0.75rem 1rem;
            text-align: center;
            color: var(--primary);
            font-weight: 500;
            font-size: 0.875rem;
            border-top: 1px solid var(--border-color);
            text-decoration: none;
        }

        .navbar-notification-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .navbar-notification-item:hover {
            background: var(--light);
        }

        .navbar-notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-notification-icon.primary {
            background: rgba(115,103,240,0.12);
            color: var(--primary);
        }

        .navbar-notification-icon.warning {
            background: rgba(255,159,67,0.12);
            color: var(--warning);
        }

        .navbar-notification-icon.success {
            background: rgba(40,199,111,0.12);
            color: var(--success);
        }

        .navbar-notification-text {
            font-size: 0.875rem;
            color: var(--text-primary);
            margin: 0;
        }

        .navbar-notification-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .navbar-user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.25rem;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .navbar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .navbar-user-avatar.lg {
            width: 48px;
            height: 48px;
            font-size: 0.875rem;
        }

        .navbar-user-info {
            text-align: left;
        }

        .navbar-user-name {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .navbar-user-role {
            display: block;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .navbar-user-dropdown {
            width: 230px;
        }

        .navbar-user-dropdown-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-user-dropdown-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .navbar-user-dropdown-email {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }

        .navbar-notifications-dropdown {
            width: 360px;
        }

        /* Main Content Area */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;

        }

        .admin-content {
            flex: 1;
            padding: 1.5rem;
        }

        /* Card Styles */
        .vuexy-card {
            background: var(--card-bg);
            border-radius: 0.5rem;
            box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .vuexy-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vuexy-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .vuexy-card-body {
            padding: 1.5rem;
        }

        /* Stat Cards */
        .vuexy-stat-card {
            background: var(--card-bg);
            border-radius: 0.5rem;
            box-shadow: 0 4px 24px 0 rgba(34,41,47,0.1);
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vuexy-stat-content h3 {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem;
        }

        .vuexy-stat-content p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .vuexy-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vuexy-stat-icon.primary {
            background: rgba(115,103,240,0.12);
            color: var(--primary);
        }

        .vuexy-stat-icon.success {
            background: rgba(40,199,111,0.12);
            color: var(--success);
        }

        .vuexy-stat-icon.warning {
            background: rgba(255,159,67,0.12);
            color: var(--warning);
        }

        .vuexy-stat-icon.danger {
            background: rgba(234,84,85,0.12);
            color: var(--danger);
        }

        .vuexy-stat-icon.info {
            background: rgba(0,207,232,0.12);
            color: var(--info);
        }

        .vuexy-stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .vuexy-stat-trend.up {
            color: var(--success);
        }

        .vuexy-stat-trend.down {
            color: var(--danger);
        }

        /* Buttons */
        .vuexy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .vuexy-btn-primary {
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 0 10px 1px rgba(115,103,240,0.4);
        }

        .vuexy-btn-primary:hover {
            box-shadow: 0 0 20px 1px rgba(115,103,240,0.6);
            transform: translateY(-2px);
        }

        .vuexy-btn-success {
            background: linear-gradient(118deg, var(--success), #48da89);
            color: white;
        }

        .vuexy-btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .vuexy-btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Badge */
        .vuexy-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 0.25rem;
        }

        .vuexy-badge-primary {
            background: rgba(115,103,240,0.12);
            color: var(--primary);
        }

        .vuexy-badge-success {
            background: rgba(40,199,111,0.12);
            color: var(--success);
        }

        .vuexy-badge-warning {
            background: rgba(255,159,67,0.12);
            color: var(--warning);
        }

        .vuexy-badge-danger {
            background: rgba(234,84,85,0.12);
            color: var(--danger);
        }

        /* Alerts */
        .vuexy-alert {
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .vuexy-alert-danger {
            background: rgba(234,84,85,0.12);
            border: 1px solid rgba(234,84,85,0.2);
            color: var(--danger);
        }

        .vuexy-alert-success {
            background: rgba(40,199,111,0.12);
            border: 1px solid rgba(40,199,111,0.2);
            color: var(--success);
        }

        /* Progress Bar */
        .vuexy-progress {
            height: 0.5rem;
            background: var(--light);
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .vuexy-progress-bar {
            height: 100%;
            border-radius: 0.25rem;
            transition: width 0.3s ease;
        }

        .vuexy-progress-bar.primary {
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
        }

        .vuexy-progress-bar.success {
            background: var(--success);
        }

        .vuexy-progress-bar.warning {
            background: var(--warning);
        }

        .vuexy-progress-bar.danger {
            background: var(--danger);
        }

        /* Table */
        .vuexy-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vuexy-table th {
            text-align: left;
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .vuexy-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .vuexy-table tr:hover td {
            background: var(--light);
        }

        /* Analytics Card */
        .analytics-card {
            background: linear-gradient(118deg, var(--primary), var(--primary-light));
            border-radius: 0.5rem;
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .analytics-card::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px;
            right: -50px;
        }

        .analytics-card h2 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
        }

        .analytics-card p {
            margin: 0;
            opacity: 0.8;
        }

        /* Activity Item */
        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: var(--text-primary);
            margin: 0 0 0.25rem;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            width: 100%;

            }
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Admin Navigation -->
            <?php echo $__env->make('admin.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page Content -->
            <main class="admin-content">
                <?php if($errors->any()): ?>
                    <div class="vuexy-alert vuexy-alert-danger mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <div>
                            <strong>Validation Error</strong>
                            <ul class="mt-2 ml-4 list-disc">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="vuexy-alert vuexy-alert-success mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <div>
                            <strong>Success</strong>
                            <p class="mt-1"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\alpine\resources\views/layouts/admin.blade.php ENDPATH**/ ?>