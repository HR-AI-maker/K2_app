@extends('layouts.admin')

@section('title', $expedition->title)

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $expedition->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $expedition->location }} • {{ $expedition->region }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.expeditions.edit', $expedition) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Edit
            </a>
            <a href="{{ route('admin.expeditions.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                ← Back to List
            </a>
        </div>
    </div>
</div>

<!-- Status Badge and Actions -->
<div class="grid grid-cols-4 gap-4 mb-8">
    <!-- Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Status</p>
        <div class="flex items-center gap-2">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                @if($expedition->status === 'open') bg-green-100 text-green-800
                @elseif($expedition->status === 'closed') bg-red-100 text-red-800
                @elseif($expedition->status === 'completed') bg-blue-100 text-blue-800
                @elseif($expedition->status === 'cancelled') bg-gray-100 text-gray-800
                @else bg-yellow-100 text-yellow-800
                @endif
            ">
                {{ ucfirst($expedition->status) }}
            </span>
        </div>
    </div>

    <!-- Difficulty Level -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Difficulty</p>
        <p class="text-lg font-bold text-gray-900">{{ ucfirst($expedition->difficulty_level) }}</p>
    </div>

    <!-- Participants -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Max Participants</p>
        <p class="text-lg font-bold text-gray-900">{{ $expedition->max_participants }}</p>
    </div>

    <!-- Permit Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Permit Required</p>
        <p class="text-lg font-bold text-gray-900">
            {{ $expedition->permit_required ? '✓ Yes' : '✗ No' }}
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="col-span-2 space-y-6">
        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Expedition Details</h2>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Start Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $expedition->start_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">End Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $expedition->end_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Duration</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $expedition->start_date->diffInDays($expedition->end_date) }} days</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Created By</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $expedition->creator->full_name ?? 'Unknown' }}</p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-2">Description</p>
                <p class="text-gray-700 whitespace-pre-line">{{ $expedition->description }}</p>
            </div>

            @if($expedition->permit_required && $expedition->permit_details)
                <div class="mt-6 pt-6 border-t">
                    <p class="text-sm text-gray-600 mb-2">Permit Details</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $expedition->permit_details }}</p>
                </div>
            @endif
        </div>

        <!-- Status Actions -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Status Management</h2>
            <div class="flex gap-4 flex-wrap">
                @if($expedition->status === 'planning')
                    <form method="POST" action="{{ route('admin.expeditions.open', $expedition) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Open for Applications
                        </button>
                    </form>
                @endif

                @if($expedition->status === 'open')
                    <form method="POST" action="{{ route('admin.expeditions.close', $expedition) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Close Applications
                        </button>
                    </form>
                @endif

                @if(in_array($expedition->status, ['open', 'closed']))
                    <form method="POST" action="{{ route('admin.expeditions.complete', $expedition) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Mark as Completed
                        </button>
                    </form>
                @endif

                @if($expedition->status !== 'completed' && $expedition->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.expeditions.cancel', $expedition) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700" onclick="return confirm('Are you sure?')">
                            Cancel Expedition
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.expeditions.destroy', $expedition) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900" onclick="return confirm('Delete permanently?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Applications Stats -->
        <div class="bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Applications</h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Total Applications</span>
                    <span class="text-2xl font-bold text-gray-900">{{ $applicationStats['total'] }}</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Pending</span>
                    <span class="text-2xl font-bold text-yellow-600">{{ $applicationStats['pending'] }}</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Approved</span>
                    <span class="text-2xl font-bold text-green-600">{{ $applicationStats['approved'] }}</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b">
                    <span class="text-gray-600">Rejected</span>
                    <span class="text-2xl font-bold text-red-600">{{ $applicationStats['rejected'] }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Cancelled</span>
                    <span class="text-2xl font-bold text-gray-600">{{ $applicationStats['cancelled'] }}</span>
                </div>
            </div>

            <a href="{{ route('admin.expeditions.applications', $expedition) }}" class="mt-6 block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                View All Applications
            </a>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Info</h3>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Location</p>
                    <p class="font-semibold text-gray-900">{{ $expedition->location }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Region</p>
                    <p class="font-semibold text-gray-900">{{ $expedition->region }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Created</p>
                    <p class="font-semibold text-gray-900">{{ $expedition->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Updated</p>
                    <p class="font-semibold text-gray-900">{{ $expedition->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
