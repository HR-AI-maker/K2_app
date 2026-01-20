<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pak Alpine') }} - @yield('title')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge {
            @apply px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full;
        }
        .btn {
            @apply px-4 py-2 rounded-lg font-semibold transition-colors;
        }
        .btn-primary {
            @apply btn bg-blue-600 text-white hover:bg-blue-700;
        }
        .input {
            @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600;
        }
        .card {
            @apply bg-white p-6 rounded-lg shadow;
        }
    </style>
</head>
<body class="bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('partials.navbar')

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
