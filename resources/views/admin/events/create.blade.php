@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to Events</a>
</div>

<!-- Create Event Form -->
<div class="bg-white rounded-lg shadow p-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Create New Event</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="font-semibold text-red-800 mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-1 text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-8">
        @csrf

        <!-- Basic Information Section -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Basic Information</h2>
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Event title" class="w-full input">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" rows="5" placeholder="Detailed event description..." class="w-full input">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                    <select name="event_type" class="w-full input">
                        <option value="">Select event type</option>
                        <option value="championship" @selected(old('event_type') === 'championship')>Championship</option>
                        <option value="training" @selected(old('event_type') === 'training')>Training</option>
                        <option value="expedition" @selected(old('event_type') === 'expedition')>Expedition</option>
                        <option value="meetup" @selected(old('event_type') === 'meetup')>Meetup</option>
                    </select>
                    @error('event_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Location Details Section -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Location Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region *</label>
                    <input type="text" name="region" value="{{ old('region') }}" placeholder="e.g., Northern Pakistan" class="w-full input">
                    @error('region')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g., Hunza Valley" class="w-full input">
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Schedule</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full input">
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full input">
                    @error('end_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Capacity & Pricing Section -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Capacity & Pricing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Max Participants -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Participants *</label>
                    <input type="number" name="max_participants" value="{{ old('max_participants') }}" placeholder="50" min="1" class="w-full input">
                    @error('max_participants')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price for Members -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (Member) - PKR *</label>
                    <input type="number" name="price_member" value="{{ old('price_member') }}" placeholder="0" min="0" step="0.01" class="w-full input">
                    @error('price_member')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price for Non-Members -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (Non-Member) - PKR *</label>
                    <input type="number" name="price_nonmember" value="{{ old('price_nonmember') }}" placeholder="0" min="0" step="0.01" class="w-full input">
                    @error('price_nonmember')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Eligibility Requirements Section -->
        <div class="border-t pt-6">
            <h2 class="text-2xl font-bold mb-4">Eligibility Requirements</h2>
            <div id="eligibility-container">
                @if (old('eligibility_requirements'))
                    @foreach (old('eligibility_requirements') as $index => $requirement)
                        <div class="flex gap-2 mb-2 eligibility-item">
                            <input type="text" name="eligibility_requirements[]" value="{{ $requirement }}" placeholder="e.g., Must have climbing experience" class="flex-1 input">
                            <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 remove-requirement" onclick="removeEligibility(this)">Remove</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold" onclick="addEligibility()">
                + Add Requirement
            </button>
            @error('eligibility_requirements')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="border-t pt-6 flex gap-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Create Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function addEligibility() {
    const container = document.getElementById('eligibility-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-2 eligibility-item';
    div.innerHTML = `
        <input type="text" name="eligibility_requirements[]" placeholder="e.g., Must have climbing experience" class="flex-1 input">
        <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 remove-requirement" onclick="removeEligibility(this)">Remove</button>
    `;
    container.appendChild(div);
}

function removeEligibility(button) {
    button.parentElement.remove();
}
</script>
@endsection
