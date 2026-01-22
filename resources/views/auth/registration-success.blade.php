@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <span class="text-4xl">✓</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome to Alpine!</h1>
            <p class="text-gray-600 mt-2">Your account is ready to go</p>
        </div>

        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-green-700 text-sm">
                ✓ Account created successfully<br>
                ✓ Email verified<br>
                ✓ Membership activated
            </p>
        </div>

        <!-- Account Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-gray-900 mb-4">Account Details</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Name:</span>
                    <span class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-semibold">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Membership Tier:</span>
                    <span class="font-semibold text-blue-600">{{ $user->membership_tier }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Expires:</span>
                    <span class="font-semibold">
                        @php
                            $transaction = $user->membershipTransactions()->latest()->first();
                            $expireDate = $transaction ? $transaction->created_at->addMonth()->format('M d, Y') : 'N/A';
                        @endphp
                        {{ $expireDate }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">🎯 Next Steps:</h3>
            <ol class="space-y-2 text-sm text-gray-700">
                <li>1. Complete your profile information</li>
                <li>2. Upload documents for verification</li>
                <li>3. Browse upcoming events and expeditions</li>
                <li>4. Connect with the climbing community</li>
            </ol>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('dashboard') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Go to Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-2 px-4 rounded-lg transition duration-200">
                Complete Profile
            </a>
        </div>

        <!-- Benefits Box -->
        <div class="mt-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">🎁 Your Membership Includes:</h3>
            <ul class="space-y-2 text-xs text-gray-700">
                <li>✓ Access to all events and expeditions</li>
                <li>✓ Community forum and discussions</li>
                <li>✓ GPS tracking capabilities</li>
                <li>✓ SOS system for emergencies</li>
                <li>✓ Offline maps and guides</li>
                <li>✓ Member-only discounts</li>
            </ul>
        </div>

        <!-- Support -->
        <div class="text-center mt-6 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-600">
                Need help? Contact us at <a href="mailto:support@alpine.com" class="text-blue-600 hover:underline">support@alpine.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
