@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.user-management.index') }}" class="text-blue-600 hover:text-blue-800 mb-6">&larr; Back to Users</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h2>
                        <a href="{{ route('admin.user-management.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            ✎ Edit User
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Phone</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->phone }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Role</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                @if($user->role === 'admin') bg-red-100 text-red-800
                                @elseif($user->role === 'vendor') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Joined</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($user->address)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-gray-600 text-sm">Address</p>
                            <p class="text-gray-900">{{ $user->address }}</p>
                        </div>
                    @endif
                </div>

                <!-- Membership Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Membership Information</h3>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-gray-600 text-sm">Tier</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->membership_tier }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                @if($user->membership_status === 'active') bg-green-100 text-green-800
                                @elseif($user->membership_status === 'pending_payment') bg-orange-100 text-orange-800
                                @elseif($user->membership_status === 'suspended') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $user->membership_status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Verified</p>
                            <p class="text-gray-900">{{ $user->membership_verified_at ? $user->membership_verified_at->format('M d, Y') : 'Not verified' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Expires</p>
                            <p class="text-gray-900">{{ $user->membership_expires_at ? $user->membership_expires_at->format('M d, Y') : 'No expiry set' }}</p>
                        </div>
                    </div>

                    <!-- Update Membership Form -->
                    <form method="POST" action="{{ route('admin.user-management.update-membership', $user) }}" class="space-y-4 pt-6 border-t border-gray-200">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Membership Status</label>
                                <select name="membership_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="active" {{ $user->membership_status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending_payment" {{ $user->membership_status === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                                    <option value="suspended" {{ $user->membership_status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="expired" {{ $user->membership_status === 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Membership Tier</label>
                                <select name="membership_tier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Choose tier...</option>
                                    @foreach($membershipTiers as $tier)
                                        <option value="{{ $tier->id }}" {{ $user->membership_tier === $tier->name ? 'selected' : '' }}>
                                            {{ $tier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                            <input type="date" name="membership_expires_at" value="{{ $user->membership_expires_at?->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Update Membership
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Password Reset -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Reset Password</h3>
                    <form method="POST" action="{{ route('admin.user-management.update-password', $user) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required minlength="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            🔑 Reset Password
                        </button>
                    </form>
                </div>

                <!-- Account Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Account Actions</h3>
                    <div class="space-y-2">
                        @if($user->membership_status !== 'suspended')
                            <form method="POST" action="{{ route('admin.user-management.suspend', $user) }}" class="block" onsubmit="return confirm('Suspend this user?');">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 text-sm">
                                    ⚠️ Suspend User
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.user-management.reactivate', $user) }}" class="block">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                    ✓ Reactivate User
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.user-management.destroy', $user) }}" class="block" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                🗑️ Delete User
                            </button>
                        </form>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Stats</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Type:</span>
                            <span class="font-semibold">{{ $user->user_type === 'local' ? 'Local' : 'Foreign' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Climbing Discipline:</span>
                            <span class="font-semibold">{{ $user->climbing_discipline ?? 'Not set' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Login:</span>
                            <span class="font-semibold">{{ $user->last_login_at?->format('M d, Y H:i') ?? 'Never' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
