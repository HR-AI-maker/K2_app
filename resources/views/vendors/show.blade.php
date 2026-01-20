@extends('layouts.app')

@section('title', $vendor->business_name)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <a href="{{ route('vendors.index') }}" class="text-green-100 hover:text-white mb-4 inline-block">
                ← Back to Vendors
            </a>
            <div class="flex items-center gap-3 mb-4">
                <span class="badge bg-green-200 text-green-900">
                    @if ($vendor->business_type === 'guide') 👨‍🏫 Guide
                    @elseif ($vendor->business_type === 'transport') 🚗 Transport
                    @elseif ($vendor->business_type === 'lodging') 🏨 Lodging
                    @elseif ($vendor->business_type === 'equipment') 🎒 Equipment
                    @else 🏪 {{ ucfirst($vendor->business_type) }}
                    @endif
                </span>
                @if ($vendor->is_certified)
                    <span class="badge bg-yellow-200 text-yellow-900">⭐ Certified</span>
                @endif
            </div>
            <h1 class="text-4xl font-bold">{{ $vendor->business_name }}</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Business Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Business Information -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold mb-6">Business Information</h2>

                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <p class="text-sm text-gray-600 mb-1">Contact Person</p>
                            <p class="font-semibold text-gray-900">{{ $vendor->contact_person }}</p>
                        </div>

                        <div class="border-b pb-4">
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <p class="font-semibold">
                                <a href="mailto:{{ $vendor->email }}" class="text-blue-600 hover:underline">
                                    {{ $vendor->email }}
                                </a>
                            </p>
                        </div>

                        <div class="border-b pb-4">
                            <p class="text-sm text-gray-600 mb-1">Phone</p>
                            <p class="font-semibold">
                                <a href="tel:{{ $vendor->phone }}" class="text-blue-600 hover:underline">
                                    {{ $vendor->phone }}
                                </a>
                            </p>
                        </div>

                        <div class="border-b pb-4">
                            <p class="text-sm text-gray-600 mb-1">📍 Location</p>
                            <p class="font-semibold">{{ $vendor->address }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Description</p>
                            <p class="text-gray-700 leading-relaxed">{{ $vendor->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Certification & Credentials -->
                @if ($vendor->is_certified)
                    <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-8">
                        <h2 class="text-2xl font-bold mb-4 text-yellow-900">⭐ Certifications</h2>
                        <p class="text-gray-700 mb-4">{{ $vendor->certification_details ?? 'This vendor is certified and verified by Pak Alpine.' }}</p>
                        <div class="inline-block px-4 py-2 bg-yellow-200 text-yellow-900 rounded-lg font-semibold">
                            ✓ Verified Vendor
                        </div>
                    </div>
                @endif

                <!-- Services Offered -->
                @if ($vendor->services->count() > 0)
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold mb-6">Services Offered</h2>

                        <div class="space-y-3">
                            @foreach ($vendor->services as $service)
                                <div class="border-l-4 border-green-500 pl-4 py-2">
                                    <p class="font-semibold text-gray-900">{{ $service->service_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                    @if ($service->price)
                                        <p class="text-sm font-semibold text-green-600 mt-1">PKR {{ number_format($service->price) }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Contact CTA -->
                <div class="bg-green-50 border border-green-300 rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-4 text-green-900">Get in Touch</h2>
                    <p class="text-gray-700 mb-6">Interested in their services? Contact them directly:</p>

                    <div class="flex flex-col md:flex-row gap-4">
                        <a href="mailto:{{ $vendor->email }}" class="btn-primary flex-1 text-center">
                            📧 Email
                        </a>
                        <a href="tel:{{ $vendor->phone }}" class="btn-primary flex-1 text-center">
                            📱 Call
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Rating & Stats Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Rating & Stats</h3>

                    <div class="text-center mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-center gap-1 mb-2">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($vendor->rating ?? 0))
                                    <span class="text-3xl text-yellow-400">★</span>
                                @elseif ($i < $vendor->rating ?? 0)
                                    <span class="text-3xl text-yellow-300">✧</span>
                                @else
                                    <span class="text-3xl text-gray-300">☆</span>
                                @endif
                            @endfor
                        </div>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ $vendor->rating ? number_format($vendor->rating, 1) : 'Unrated' }}
                        </p>
                    </div>

                    <div class="space-y-3 border-t border-gray-200 pt-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Bookings</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $vendor->total_bookings ?? 0 }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Type</p>
                            <p class="font-semibold capitalize">{{ $vendor->business_type }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Verification Status</p>
                            <p class="font-semibold capitalize text-green-600">{{ $vendor->status }}</p>
                        </div>

                        @if ($vendor->verified_at)
                            <div>
                                <p class="text-sm text-gray-600">Verified</p>
                                <p class="text-sm">{{ $vendor->verified_at->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Business Type Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Business Type</h3>

                    @php
                        $typeInfo = [
                            'guide' => ['icon' => '👨‍🏫', 'description' => 'Professional mountain guides offering climbing, trekking, and expedition services.'],
                            'transport' => ['icon' => '🚗', 'description' => 'Transportation services for logistics and group movement.'],
                            'lodging' => ['icon' => '🏨', 'description' => 'Accommodation facilities and hospitality services.'],
                            'equipment' => ['icon' => '🎒', 'description' => 'Equipment rental and sales for outdoor activities.'],
                            'other' => ['icon' => '🏪', 'description' => 'Other services related to alpine activities.'],
                        ];
                    @endphp

                    <div class="text-center">
                        <p class="text-4xl mb-2">{{ $typeInfo[$vendor->business_type]['icon'] ?? '🏪' }}</p>
                        <p class="font-semibold capitalize mb-2">{{ $vendor->business_type }}</p>
                        <p class="text-sm text-gray-600">{{ $typeInfo[$vendor->business_type]['description'] ?? '' }}</p>
                    </div>
                </div>

                <!-- Certification Badge -->
                @if ($vendor->is_certified)
                    <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-3 text-yellow-900">⭐ Certified Vendor</h3>
                        <p class="text-sm text-yellow-800 mb-3">This vendor has been verified and certified by Pak Alpine, meeting our standards for quality and reliability.</p>
                        <div class="text-center">
                            <p class="text-4xl">🏆</p>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-3 text-gray-900">Verification Pending</h3>
                        <p class="text-sm text-gray-600">This vendor is currently undergoing verification by Pak Alpine.</p>
                    </div>
                @endif

                <!-- Share & Contact -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold mb-4">Quick Contact</h3>

                    <div class="space-y-2">
                        <a href="mailto:{{ $vendor->email }}" class="block w-full px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 text-center font-semibold transition">
                            📧 Email
                        </a>
                        <a href="tel:{{ $vendor->phone }}" class="block w-full px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 text-center font-semibold transition">
                            📱 Call
                        </a>
                        <a href="{{ route('vendors.index') }}" class="block w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-center font-semibold transition">
                            ← Back to Vendors
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
