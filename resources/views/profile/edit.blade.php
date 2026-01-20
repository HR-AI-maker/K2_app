@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-2">Update your personal information</p>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-bold text-gray-900 mb-2">First Name *</label>
                    <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        value="{{ old('first_name', $user->first_name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('first_name') border-red-600 @enderror"
                        required
                    >
                    @error('first_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-bold text-gray-900 mb-2">Last Name *</label>
                    <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        value="{{ old('last_name', $user->last_name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('last_name') border-red-600 @enderror"
                        required
                    >
                    @error('last_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                    <input
                        type="email"
                        value="{{ $user->email }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                        disabled
                    >
                    <p class="text-xs text-gray-600 mt-1">Email cannot be changed</p>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Phone Number *</label>
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('phone') border-red-600 @enderror"
                        placeholder="+92 3XX XXXXXXX"
                        required
                    >
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-bold text-gray-900 mb-2">Address</label>
                    <textarea
                        name="address"
                        id="address"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('address') border-red-600 @enderror"
                        placeholder="Street address, city, postal code"
                    >{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Climbing Discipline -->
                <div>
                    <label for="climbing_discipline" class="block text-sm font-bold text-gray-900 mb-2">Climbing Discipline *</label>
                    <select
                        name="climbing_discipline"
                        id="climbing_discipline"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('climbing_discipline') border-red-600 @enderror"
                        required
                    >
                        <option value="">Select your primary discipline</option>
                        <option value="rock" {{ old('climbing_discipline', $user->climbing_discipline) === 'rock' ? 'selected' : '' }}>Rock Climbing</option>
                        <option value="alpine" {{ old('climbing_discipline', $user->climbing_discipline) === 'alpine' ? 'selected' : '' }}>Alpine Climbing</option>
                        <option value="ice" {{ old('climbing_discipline', $user->climbing_discipline) === 'ice' ? 'selected' : '' }}>Ice Climbing</option>
                        <option value="mountaineering" {{ old('climbing_discipline', $user->climbing_discipline) === 'mountaineering' ? 'selected' : '' }}>Mountaineering</option>
                        <option value="trekking" {{ old('climbing_discipline', $user->climbing_discipline) === 'trekking' ? 'selected' : '' }}>Trekking</option>
                        <option value="mixed" {{ old('climbing_discipline', $user->climbing_discipline) === 'mixed' ? 'selected' : '' }}>Mixed Climbing</option>
                    </select>
                    @error('climbing_discipline')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-4">
                    <button
                        type="submit"
                        class="btn-primary flex-1"
                    >
                        Save Changes
                    </button>
                    <a
                        href="{{ route('dashboard') }}"
                        class="btn px-6 py-2 bg-gray-600 text-white hover:bg-gray-700 flex items-center justify-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('profile.medical') }}" class="card text-center hover:shadow-lg transition">
                <p class="text-3xl mb-2">🏥</p>
                <p class="font-semibold">Medical Info</p>
                <p class="text-sm text-gray-600">Update health details</p>
            </a>
            <a href="{{ route('profile.documents') }}" class="card text-center hover:shadow-lg transition">
                <p class="text-3xl mb-2">📄</p>
                <p class="font-semibold">Documents</p>
                <p class="text-sm text-gray-600">Upload documents</p>
            </a>
            <a href="{{ route('profile.membership') }}" class="card text-center hover:shadow-lg transition">
                <p class="text-3xl mb-2">💳</p>
                <p class="font-semibold">Membership</p>
                <p class="text-sm text-gray-600">View membership</p>
            </a>
        </div>
    </div>
</div>
@endsection
