@extends('layouts.app')

@section('title', 'My Badges')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">🏆 My Badges</h1>
            <p class="text-gray-600 mt-2">Achievements and recognition</p>
        </div>

        @if ($user->badges->count() > 0)
            <!-- Badges Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($user->badges as $badge)
                    <div class="card text-center hover:shadow-lg transition transform hover:scale-105">
                        <div class="text-6xl mb-3">{{ $badge->icon_path }}</div>
                        <h3 class="font-bold text-lg mb-1">{{ $badge->name }}</h3>
                        <span class="badge inline-block mb-2
                            @if ($badge->tier === 'bronze') bg-yellow-100 text-yellow-800
                            @elseif ($badge->tier === 'silver') bg-gray-100 text-gray-800
                            @elseif ($badge->tier === 'gold') bg-yellow-100 text-yellow-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ ucfirst($badge->tier) }}
                        </span>
                        <p class="text-sm text-gray-600 mb-3">{{ $badge->description }}</p>
                        <p class="text-xs text-gray-500">
                            Earned {{ \Carbon\Carbon::parse($badge->pivot->created_at)->format('M d, Y') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Badge Statistics -->
            <div class="card mb-8">
                <h2 class="text-2xl font-bold mb-6">📊 Badge Statistics</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-6 border rounded-lg">
                        <p class="text-4xl font-bold text-blue-600">{{ $user->badges->count() }}</p>
                        <p class="text-gray-600 mt-2">Total Earned</p>
                    </div>
                    <div class="text-center p-6 border rounded-lg">
                        <p class="text-4xl font-bold text-yellow-600">{{ $user->badges->where('tier', 'bronze')->count() }}</p>
                        <p class="text-gray-600 mt-2">Bronze Badges</p>
                    </div>
                    <div class="text-center p-6 border rounded-lg">
                        <p class="text-4xl font-bold text-gray-400">{{ $user->badges->where('tier', 'silver')->count() }}</p>
                        <p class="text-gray-600 mt-2">Silver Badges</p>
                    </div>
                    <div class="text-center p-6 border rounded-lg">
                        <p class="text-4xl font-bold text-yellow-500">{{ $user->badges->where('tier', 'gold')->count() }}</p>
                        <p class="text-gray-600 mt-2">Gold Badges</p>
                    </div>
                </div>
            </div>
        @else
            <!-- No Badges -->
            <div class="card text-center py-16">
                <p class="text-6xl mb-4">🎯</p>
                <p class="text-2xl font-bold text-gray-600 mb-2">No Badges Yet</p>
                <p class="text-gray-500 mb-6">Start participating in activities to earn badges</p>
                <a href="{{ route('events.index') }}" class="btn-primary inline-block">
                    Browse Events
                </a>
            </div>
        @endif

        <!-- Available Badges (locked) -->
        <div class="card">
            <h2 class="text-2xl font-bold mb-6">🔒 Available Badges</h2>
            <p class="text-gray-600 mb-6">Badges you can earn by participating in activities</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Badge 1 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🥾</div>
                    <h3 class="font-bold text-lg mb-2">First Hike</h3>
                    <p class="text-sm text-gray-600 mb-4">Register for your first event</p>
                    <p class="text-xs text-gray-500">
                        @if ($user->eventRegistrations->count() > 0)
                            ✓ Unlocked
                        @else
                            🔒 Locked
                        @endif
                    </p>
                </div>

                <!-- Badge 2 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🏔️</div>
                    <h3 class="font-bold text-lg mb-2">Alpine Explorer</h3>
                    <p class="text-sm text-gray-600 mb-4">Complete 5 different expeditions</p>
                    <p class="text-xs text-gray-500">
                        @if ($user->expeditionApplications->where('status', 'approved')->count() >= 5)
                            ✓ Unlocked
                        @else
                            🔒 {{ $user->expeditionApplications->where('status', 'approved')->count() }}/5
                        @endif
                    </p>
                </div>

                <!-- Badge 3 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🤝</div>
                    <h3 class="font-bold text-lg mb-2">Community Builder</h3>
                    <p class="text-sm text-gray-600 mb-4">Create 10 community posts</p>
                    <p class="text-xs text-gray-500">
                        @if ($user->communityPosts->count() >= 10)
                            ✓ Unlocked
                        @else
                            🔒 {{ $user->communityPosts->count() }}/10
                        @endif
                    </p>
                </div>

                <!-- Badge 4 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">👑</div>
                    <h3 class="font-bold text-lg mb-2">Member Elite</h3>
                    <p class="text-sm text-gray-600 mb-4">Achieve Premium membership</p>
                    <p class="text-xs text-gray-500">
                        @if ($user->membership_tier === 'premium' || $user->membership_tier === 'lifetime')
                            ✓ Unlocked
                        @else
                            🔒 Upgrade to unlock
                        @endif
                    </p>
                </div>

                <!-- Badge 5 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🛂</div>
                    <h3 class="font-bold text-lg mb-2">Global Adventurer</h3>
                    <p class="text-sm text-gray-600 mb-4">Participate in international expedition</p>
                    <p class="text-xs text-gray-500">🔒 Future unlock</p>
                </div>

                <!-- Badge 6 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🎓</div>
                    <h3 class="font-bold text-lg mb-2">Certified Instructor</h3>
                    <p class="text-sm text-gray-600 mb-4">Complete guide certification</p>
                    <p class="text-xs text-gray-500">🔒 Coming soon</p>
                </div>

                <!-- Badge 7 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">⚡</div>
                    <h3 class="font-bold text-lg mb-2">Quick Response</h3>
                    <p class="text-sm text-gray-600 mb-4">Register for event within 1 day</p>
                    <p class="text-xs text-gray-500">🔒 Unlock by being fast</p>
                </div>

                <!-- Badge 8 -->
                <div class="card text-center opacity-60 grayscale">
                    <div class="text-6xl mb-3">🌟</div>
                    <h3 class="font-bold text-lg mb-2">Superstar</h3>
                    <p class="text-sm text-gray-600 mb-4">Unlock all other badges</p>
                    <p class="text-xs text-gray-500">🔒 Ultimate achievement</p>
                </div>
            </div>
        </div>

        <!-- How to Earn Badges -->
        <div class="mt-8 card bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-600">
            <h2 class="text-2xl font-bold mb-4">💡 How to Earn Badges</h2>
            <div class="space-y-3">
                <p class="text-gray-700">
                    <strong>Badges</strong> are awarded automatically when you achieve certain milestones. Keep participating in activities, register for events, contribute to the community, and maintain your membership to unlock special achievements!
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>Register for and attend events</li>
                    <li>Apply for and complete expeditions</li>
                    <li>Create valuable community posts</li>
                    <li>Upgrade your membership tier</li>
                    <li>Maintain consistent participation</li>
                    <li>Complete certifications and trainings</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
