@extends('layouts.admin')

@section('title', $member->full_name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Members</a>
</div>

<!-- Member Header -->
<div class="bg-white rounded-lg shadow mb-6 p-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $member->full_name }}</h1>
            <p class="text-gray-600 mt-2">{{ $member->email }} • {{ $member->phone }}</p>
            <div class="mt-4 flex gap-3">
                <span class="px-3 py-1 text-sm font-semibold rounded-full
                    @if($member->membership_status === 'active') bg-green-100 text-green-800
                    @elseif($member->membership_status === 'expired') bg-red-100 text-red-800
                    @elseif($member->membership_status === 'suspended') bg-purple-100 text-purple-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($member->membership_status) }}
                </span>
                <span class="badge">{{ ucfirst($member->membership_tier) }}</span>
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ ucfirst($member->user_type) }}
                </span>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.members.edit', $member) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Edit
            </a>
            @if($member->membership_verified_at === null)
                <form method="POST" action="{{ route('admin.members.verify', $member) }}" class="inline">
                    @csrf
                    <input type="hidden" name="tier" value="standard">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                        Verify
                    </button>
                </form>
            @endif
            @if($member->membership_status === 'active')
                <form method="POST" action="{{ route('admin.members.suspend', $member) }}" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Suspend this member?')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        Suspend
                    </button>
                </form>
            @elseif($member->membership_status === 'suspended' || $member->membership_status === 'expired')
                <form method="POST" action="{{ route('admin.members.reactivate', $member) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                        Reactivate
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">First Name</p>
                    <p class="font-semibold text-gray-900">{{ $member->first_name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Last Name</p>
                    <p class="font-semibold text-gray-900">{{ $member->last_name }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="font-semibold text-gray-900">{{ $member->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Phone</p>
                    <p class="font-semibold text-gray-900">{{ $member->phone }}</p>
                </div>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Address</p>
                <p class="font-semibold text-gray-900">{{ $member->address ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Climbing Discipline</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($member->climbing_discipline) }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Quick Stats</h2>
        <div class="space-y-3">
            <div class="border-l-4 border-blue-500 pl-4">
                <p class="text-gray-600 text-sm">Member Since</p>
                <p class="font-semibold">{{ $member->created_at->format('d M Y') }}</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4">
                <p class="text-gray-600 text-sm">Last Login</p>
                <p class="font-semibold">{{ $member->last_login_at?->format('d M Y H:i') ?? 'Never' }}</p>
            </div>
            <div class="border-l-4 border-purple-500 pl-4">
                <p class="text-gray-600 text-sm">Verified On</p>
                <p class="font-semibold">{{ $member->membership_verified_at?->format('d M Y') ?? 'Not verified' }}</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <p class="text-gray-600 text-sm">Event Registrations</p>
                <p class="font-semibold">{{ $member->eventRegistrations->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Membership History -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-2xl font-bold mb-4">Membership History</h2>
    @if($member->membershipHistory->count() > 0)
        <div class="space-y-3">
            @foreach($member->membershipHistory as $history)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">{{ ucfirst($history->membership_tier) }} - {{ ucfirst($history->status) }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $history->started_at->format('d M Y') }} to {{ $history->expires_at->format('d M Y') }}
                            </p>
                        </div>
                        @if($history->isExpired())
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Expired</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No membership history available</p>
    @endif
</div>

<!-- Documents -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-2xl font-bold mb-4">Uploaded Documents</h2>
    @if($member->documents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($member->documents as $doc)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">{{ ucfirst($doc->document_type) }}</p>
                            <p class="text-sm text-gray-600">Uploaded: {{ $doc->created_at->format('d M Y') }}</p>
                            @if($doc->verified_at)
                                <p class="text-sm text-green-600 font-semibold">✓ Verified</p>
                            @elseif($doc->rejection_reason)
                                <p class="text-sm text-red-600 font-semibold">✗ Rejected</p>
                                <p class="text-xs text-red-600">{{ $doc->rejection_reason }}</p>
                            @else
                                <p class="text-sm text-yellow-600 font-semibold">⏳ Pending</p>
                            @endif
                        </div>
                        @if($doc->document_url)
                            <a href="{{ $doc->document_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                View
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No documents uploaded</p>
    @endif
</div>

<!-- Medical Information -->
@if($member->medicalInfo)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Medical Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Blood Type</p>
                <p class="font-semibold text-gray-900">{{ $member->medicalInfo->blood_type ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Allergies</p>
                <p class="font-semibold text-gray-900">
                    {{ !empty($member->medicalInfo->allergies) ? implode(', ', $member->medicalInfo->allergies) : 'None' }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Emergency Contact</p>
                <p class="font-semibold text-gray-900">
                    {{ $member->medicalInfo->emergency_contact_name ?? 'Not provided' }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Insurance Provider</p>
                <p class="font-semibold text-gray-900">{{ $member->medicalInfo->insurance_provider ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>
@endif
@endsection
