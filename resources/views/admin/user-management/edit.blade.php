@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.user-management.show', $user) }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back</a>

        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit User: {{ $user->full_name }}</h1>

            <form method="POST" action="{{ route('admin.user-management.update', $user) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name*</label>
                        <input type="text" name="first_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" value="{{ old('first_name', $user->first_name) }}">
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name*</label>
                        <input type="text" name="last_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email*</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone*</label>
                        <input type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role*</label>
                    <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                        <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                        <option value="vendor" {{ old('role', $user->role) === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Membership Tier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Membership Tier</label>
                        <select name="membership_tier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Choose tier...</option>
                            @foreach($membershipTiers as $tier)
                                <option value="{{ $tier->id }}" {{ old('membership_tier', $user->membership_tier) === $tier->name ? 'selected' : '' }}>
                                    {{ $tier->name }} (Rs. {{ number_format($tier->price, 0) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Membership Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Membership Status</label>
                        <select name="membership_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="pending_payment" {{ old('membership_status', $user->membership_status) === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="active" {{ old('membership_status', $user->membership_status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ old('membership_status', $user->membership_status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="expired" {{ old('membership_status', $user->membership_status) === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        Update User
                    </button>
                    <a href="{{ route('admin.user-management.show', $user) }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
