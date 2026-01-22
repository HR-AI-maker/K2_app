<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pak Alpine') }} - Member @yield('title')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js Library for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Design System CSS -->
    <link rel="stylesheet" href="/build/assets/app-Ds-1r3fb.css">

    <style>
        /* Member Dashboard Styles */
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
        }

        body {
            background: var(--light);
            color: var(--text-primary);
        }

        /* Card Styles */
        .member-card {
            background: white;
            border-radius: 0.875rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .member-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        /* Gradient Accents */
        .gradient-accent {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        /* Soft shadows */
        .shadow-soft {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('partials.navbar')

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>
</body>
</html>
