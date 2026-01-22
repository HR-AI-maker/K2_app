<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pak Alpine') }} - @yield('title')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js Library for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Design System CSS -->
    <link rel="stylesheet" href="/build/assets/app-Ds-1r3fb.css">

    <style>
        /* Premium gradient backgrounds */
        .gradient-hero {
            background: linear-gradient(135deg, #1e5f8a 0%, #0f3d56 50%, #2a7f5e 100%);
        }

        .gradient-auth {
            background: linear-gradient(135deg, rgba(30, 95, 138, 0.95) 0%, rgba(15, 61, 86, 0.95) 100%);
        }

        /* Glassmorphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Premium shadows */
        .shadow-premium {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        /* Micro-interactions */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>
