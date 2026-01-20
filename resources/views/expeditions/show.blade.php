@extends('layouts.app')

@section('title', $expedition->title)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <a href="{{ route('expeditions.index') }}" class="text-green-100 hover:text-white mb-4 inline-block">
                ← Back to Expeditions
            </a>
            <h1 class="text-4xl font-bold mb-2">{{ $expedition->title }}</h1>
            <div class="flex gap-3 flex-wrap">
                @php
                    $colors = [
                        'beginner' => 'bg-green-200 text-green-900',
                        'intermediate' => 'bg-yellow-200 text-yellow-900',
                        'advanced' => 'bg-orange-200 text-orange-900',
                        'expert' => 'bg-red-200 text-red-900',
                    ];
                    $color = $colors[$expedition->difficulty_level] ?? 'bg-gray-200 text-gray-900';
                @endphp
                <span class="badge {{ $color }}">{{ ucfirst($expedition->difficulty_level) }} Level</span>
                @if ($expedition->permit_required)
                    <span class="badge bg-blue-200 text-blue-900">Permit Required</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Expedition Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">START DATE</p>
                        <p class="font-bold text-lg">{{ $expedition->start_date->format('M d') }}</p>
                        <p class="text-xs text-gray-600">{{ $expedition->start_date->format('Y') }}</p>
                    </div>
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">DURATION</p>
                        <p class="font-bold text-lg">
                            {{ $expedition->start_date->diffInDays($expedition->end_date) + 1 }} days
                        </p>
                    </div>
                    <div class="card">
                        <p class="text-xs text-gray-500 mb-1">LOCATION</p>
                        <p class="font-bold text-lg">{{ $expedition->region }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">About This Expedition</h2>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $expedition->description }}</p>
                </div>

                <!-- Details -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-6">Expedition Details</h2>
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">📍 Location</h3>
                            <p class="text-gray-700">{{ $expedition->location }}, {{ $expedition->region }}</p>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">📅 Schedule</h3>
                            <p class="text-gray-700">
                                <strong>Start:</strong> {{ $expedition->start_date->format('F d, Y') }}<br>
                                <strong>End:</strong> {{ $expedition->end_date->format('F d, Y') }}<br>
                                <strong>Duration:</strong> {{ $expedition->start_date->diffInDays($expedition->end_date) + 1 }} days
                            </p>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold text-gray-900 mb-2">👥 Participants</h3>
                            <p class="text-gray-700">
                                <strong>Max Capacity:</strong> {{ $expedition->max_participants }}<br>
                                <strong>Approved:</strong> {{ $approvedCount }}<br>
                                <strong>Available:</strong> {{ $availableSlots }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">🎯 Difficulty Level</h3>
                            <p class="text-gray-700">
                                {{ ucfirst($expedition->difficulty_level) }}
                                <span class="text-xs text-gray-600 ml-2">
                                    @switch($expedition->difficulty_level)
                                        @case('beginner')
                                            - Suitable for first-time trekkers
                                            @break
                                        @case('intermediate')
                                            - Requires previous trekking experience
                                            @break
                                        @case('advanced')
                                            - For experienced mountaineers
                                            @break
                                        @case('expert')
                                            - For expert alpinists only
                                            @break
                                    @endswitch
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Permit Information -->
                @if ($expedition->permit_required && $expedition->permit_details)
                    <div class="card">
                        <h2 class="text-2xl font-bold mb-4">📜 Permit Requirements</h2>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $expedition->permit_details }}</p>
                    </div>
                @endif

                <!-- Organizer Info -->
                <div class="card">
                    <h2 class="text-2xl font-bold mb-4">Organized By</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($expedition->creator->first_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ $expedition->creator->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $expedition->creator->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Application -->
            <div>
                <!-- Application Card -->
                <div class="card sticky top-4">
                    <h2 class="text-2xl font-bold mb-4">Apply Now</h2>

                    <!-- Status -->
                    <div class="mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                        @if ($userApplication)
                            <p class="font-semibold text-green-900">
                                Your Status: <span class="uppercase text-green-600">{{ $userApplication->status }}</span>
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                Applied on {{ $userApplication->created_at->format('M d, Y') }}
                            </p>
                        @else
                            @if ($isFull)
                                <p class="text-sm text-gray-700">This expedition is full, but you can still apply for the waitlist.</p>
                            @else
                                <p class="text-sm text-gray-700">
                                    {{ $availableSlots }} {{ $availableSlots === 1 ? 'slot' : 'slots' }} available
                                </p>
                            @endif
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if (auth()->check())
                        @if (!$userApplication)
                            <a href="{{ route('expeditions.apply', $expedition) }}" class="btn-primary w-full text-center block mb-3">
                                {{ $isFull ? 'Join Waitlist' : 'Apply Now' }}
                            </a>
                        @else
                            <button disabled class="btn-primary w-full opacity-50 cursor-not-allowed mb-3">
                                Application Submitted
                            </button>
                            @if ($userApplication->status === 'pending')
                                <p class="text-xs text-gray-600 text-center mt-2">
                                    Admins will review your application and notify you soon.
                                </p>
                            @elseif ($userApplication->status === 'approved')
                                <div class="mt-3 p-3 bg-green-100 rounded text-sm text-green-800">
                                    ✓ Your application has been approved!
                                </div>
                            @elseif ($userApplication->status === 'rejected')
                                <div class="mt-3 p-3 bg-red-100 rounded text-sm text-red-800">
                                    ✗ Your application was not approved.
                                    @if ($userApplication->rejected_reason)
                                        <br><strong>Reason:</strong> {{ $userApplication->rejected_reason }}
                                    @endif
                                </div>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center block mb-3">
                            Login to Apply
                        </a>
                        <p class="text-xs text-gray-600 text-center">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-green-600 hover:underline">Sign up</a>
                        </p>
                    @endif

                    <!-- Additional Info -->
                    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-xs font-semibold text-yellow-900 mb-2">ℹ️ Requirements</p>
                        <ul class="text-xs text-gray-700 space-y-1">
                            <li>✓ Complete your profile</li>
                            <li>✓ Upload all required documents</li>
                            <li>✓ Meet fitness requirements</li>
                            @if ($expedition->permit_required)
                                <li>✓ Have/be prepared for permit</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
