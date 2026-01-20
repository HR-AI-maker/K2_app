@extends('layouts.admin')

@section('title', $event->title)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Events</a>
</div>

<!-- Event Header -->
<div class="bg-white rounded-lg shadow mb-6 p-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $event->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $event->location }} • {{ $event->region }}</p>
            <div class="mt-4 flex gap-3">
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ ucfirst($event->event_type) }}
                </span>
                <span class="px-3 py-1 text-sm font-semibold rounded-full
                    @if($event->status === 'published') bg-green-100 text-green-800
                    @elseif($event->status === 'draft') bg-yellow-100 text-yellow-800
                    @elseif($event->status === 'cancelled') bg-red-100 text-red-800
                    @elseif($event->status === 'completed') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($event->status) }}
                </span>
            </div>
        </div>

        <div class="flex gap-2 flex-wrap justify-end">
            <a href="{{ route('admin.events.edit', $event) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                ✏️ Edit
            </a>

            @if($event->status === 'draft')
                <form method="POST" action="{{ route('admin.events.publish', $event) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                        ✓ Publish
                    </button>
                </form>
            @endif

            @if($event->status === 'published')
                <form method="POST" action="{{ route('admin.events.complete', $event) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-semibold">
                        ✓ Complete
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.events.cancel', $event) }}" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Cancel this event?')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        ✕ Cancel
                    </button>
                </form>
            @endif

            @if($event->status !== 'completed')
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this event?')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
                        🗑️ Delete
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Event Information -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Event Information</h2>
        <div class="space-y-4">
            <!-- Description -->
            <div>
                <p class="text-gray-600 text-sm">Description</p>
                <p class="font-semibold text-gray-900 mt-1">{{ $event->description }}</p>
            </div>

            <!-- Location Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Region</p>
                    <p class="font-semibold text-gray-900">{{ $event->region }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Location</p>
                    <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                </div>
            </div>

            <!-- Schedule -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Start Date</p>
                    <p class="font-semibold text-gray-900">{{ $event->start_date->format('d M Y - H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">End Date</p>
                    <p class="font-semibold text-gray-900">{{ $event->end_date->format('d M Y - H:i') }}</p>
                </div>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Member Price</p>
                    <p class="font-semibold text-gray-900">PKR {{ number_format($event->price_member, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Non-Member Price</p>
                    <p class="font-semibold text-gray-900">PKR {{ number_format($event->price_nonmember, 2) }}</p>
                </div>
            </div>

            <!-- Eligibility Requirements -->
            @if($event->eligibility_requirements && count($event->eligibility_requirements) > 0)
                <div>
                    <p class="text-gray-600 text-sm">Eligibility Requirements</p>
                    <ul class="mt-2 space-y-1">
                        @foreach($event->eligibility_requirements as $requirement)
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2">•</span>
                                <span class="font-semibold text-gray-900">{{ $requirement }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats Sidebar -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Quick Stats</h2>
        <div class="space-y-3">
            <div class="border-l-4 border-blue-500 pl-4">
                <p class="text-gray-600 text-sm">Total Registrations</p>
                <p class="font-semibold text-lg">{{ $stats['total_registrations'] }}</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4">
                <p class="text-gray-600 text-sm">Confirmed</p>
                <p class="font-semibold text-lg">{{ $stats['confirmed'] }}</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <p class="text-gray-600 text-sm">Waitlisted</p>
                <p class="font-semibold text-lg">{{ $stats['waitlisted'] }}</p>
            </div>
            <div class="border-l-4 border-red-500 pl-4">
                <p class="text-gray-600 text-sm">Cancelled</p>
                <p class="font-semibold text-lg">{{ $stats['cancelled'] }}</p>
            </div>
            <div class="border-l-4 border-purple-500 pl-4">
                <p class="text-gray-600 text-sm">Capacity</p>
                <p class="font-semibold text-lg">
                    @php
                        $capacity = ($stats['confirmed'] / $event->max_participants) * 100;
                    @endphp
                    {{ $stats['confirmed'] }}/{{ $event->max_participants }} ({{ round($capacity) }}%)
                </p>
            </div>
            <div class="border-l-4 border-gray-500 pl-4">
                <p class="text-gray-600 text-sm">Created By</p>
                <p class="font-semibold">{{ $event->creator->first_name }} {{ $event->creator->last_name }}</p>
                <p class="text-xs text-gray-600">{{ $event->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Registrations Section -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">Registrations</h2>

    @if($stats['total_registrations'] > 0)
        <div class="space-y-4">
            @forelse($registrations as $status => $registrationList)
                <div>
                    <h3 class="text-lg font-semibold mb-2 capitalize">
                        {{ $status }} ({{ count($registrationList) }})
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">User</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Email</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Payment</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Registered</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($registrationList as $registration)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            <p class="font-semibold text-gray-900">{{ $registration->user->first_name }} {{ $registration->user->last_name }}</p>
                                        </td>
                                        <td class="px-4 py-2 text-gray-600">{{ $registration->user->email }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                                                @if($registration->status === 'registered') bg-green-100 text-green-800
                                                @elseif($registration->status === 'waitlisted') bg-yellow-100 text-yellow-800
                                                @elseif($registration->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($registration->payment_verified_at)
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">✓ Verified</span>
                                            @elseif($registration->amount_paid)
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">⏳ Pending</span>
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-gray-600">{{ $registration->registered_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No registrations yet for this event.</p>
            @endforelse
        </div>
    @else
        <p class="text-gray-600">No registrations yet for this event.</p>
    @endif
</div>
@endsection
