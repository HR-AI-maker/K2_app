@extends('layouts.admin')

@section('title', 'Edit ' . $member->full_name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.members.show', $member) }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Profile</a>
</div>

<!-- Edit Form -->
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Member: {{ $member->full_name }}</h1>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.members.update', $member) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Personal Information -->
        <div class="border-b pb-6">
            <h2 class="text-xl font-bold mb-4">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required class="input">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" required class="input">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="2" class="input">{{ old('address', $member->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Climbing Discipline</label>
                    <select name="climbing_discipline" required class="input">
                        <option value="trekking" @selected(old('climbing_discipline', $member->climbing_discipline) === 'trekking')>Trekking</option>
                        <option value="rock" @selected(old('climbing_discipline', $member->climbing_discipline) === 'rock')>Rock Climbing</option>
                        <option value="ice" @selected(old('climbing_discipline', $member->climbing_discipline) === 'ice')>Ice Climbing</option>
                        <option value="mountaineering" @selected(old('climbing_discipline', $member->climbing_discipline) === 'mountaineering')>Mountaineering</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                    <select name="user_type" required class="input">
                        <option value="local" @selected(old('user_type', $member->user_type) === 'local')>Local</option>
                        <option value="foreign" @selected(old('user_type', $member->user_type) === 'foreign')>Foreign</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Membership Settings -->
        <div class="border-b pb-6">
            <h2 class="text-xl font-bold mb-4">Membership Settings</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Membership Tier</label>
                    <select name="membership_tier" required class="input">
                        <option value="pending" @selected(old('membership_tier', $member->membership_tier) === 'pending')>Pending</option>
                        <option value="standard" @selected(old('membership_tier', $member->membership_tier) === 'standard')>Standard</option>
                        <option value="premium" @selected(old('membership_tier', $member->membership_tier) === 'premium')>Premium</option>
                        <option value="lifetime" @selected(old('membership_tier', $member->membership_tier) === 'lifetime')>Lifetime</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Membership Status</label>
                    <select name="membership_status" required class="input">
                        <option value="active" @selected(old('membership_status', $member->membership_status) === 'active')>Active</option>
                        <option value="expired" @selected(old('membership_status', $member->membership_status) === 'expired')>Expired</option>
                        <option value="suspended" @selected(old('membership_status', $member->membership_status) === 'suspended')>Suspended</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Note:</strong> Admin overrides bypass normal verification workflows. Changes are applied immediately.
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Save Changes
            </button>
            <a href="{{ route('admin.members.show', $member) }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
