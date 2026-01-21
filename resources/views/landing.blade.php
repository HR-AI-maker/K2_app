<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpine - Mountain Adventure Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 min-h-screen flex items-center justify-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern>
            <rect width="100" height="100" fill="url(#grid)" />
        </svg>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo and Header -->
        <div class="text-center mb-12">
            <div class="text-6xl mb-4">🏔️</div>
            <h1 class="text-5xl font-bold text-white mb-2">Alpine</h1>
            <p class="text-xl text-blue-200">Mountain Adventure Platform</p>
        </div>

        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow-2xl p-12 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Welcome Climber!</h2>
                <p class="text-gray-600 text-lg">
                    Join our climbing community, explore expeditions, connect with climbers, and access exclusive features.
                </p>
            </div>

            <!-- Features Highlight -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-8">
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🎯</span>
                        <span class="text-gray-700"><strong>Community:</strong> Connect with climbers</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🗻</span>
                        <span class="text-gray-700"><strong>Expeditions:</strong> Join adventures</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🛒</span>
                        <span class="text-gray-700"><strong>Marketplace:</strong> Buy/sell gear</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">📍</span>
                        <span class="text-gray-700"><strong>GPS & SOS:</strong> Stay safe</span>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200 text-lg">
                    ✉️ Sign In
                </a>

                <a href="{{ route('member.register') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200 text-lg">
                    🚀 Create Account
                </a>
            </div>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-3 text-gray-500 text-sm">or</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Vendor/Admin Info -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                <p class="text-sm text-amber-900">
                    <strong>Are you a vendor or admin?</strong> Use your assigned credentials at login.
                </p>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-lg p-4 text-center shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-2">⚡</div>
                <h3 class="font-bold text-gray-900 mb-1">Quick Setup</h3>
                <p class="text-xs text-gray-600">Get started in minutes</p>
            </div>
            <div class="bg-white rounded-lg p-4 text-center shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-2">🔒</div>
                <h3 class="font-bold text-gray-900 mb-1">Secure</h3>
                <p class="text-xs text-gray-600">Your data is safe</p>
            </div>
            <div class="bg-white rounded-lg p-4 text-center shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-2">🌍</div>
                <h3 class="font-bold text-gray-900 mb-1">Community</h3>
                <p class="text-xs text-gray-600">10K+ climbers</p>
            </div>
            <div class="bg-white rounded-lg p-4 text-center shadow-lg hover:shadow-xl transition">
                <div class="text-4xl mb-2">💰</div>
                <h3 class="font-bold text-gray-900 mb-1">Affordable</h3>
                <p class="text-xs text-gray-600">From Rs. 1000/month</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-blue-200 text-sm">
            <p class="mb-2">All features available after login</p>
            <p class="text-xs">© 2025 Alpine. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
