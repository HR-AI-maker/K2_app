@extends('layouts.admin')

@section('title', 'Edit Expedition')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Edit Expedition</h1>
            <p class="text-gray-600 mt-2">Update expedition details</p>
        </div>
        <a href="{{ route('admin.expeditions.show', $expedition) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Expedition
        </a>
    </div>
</div>

<!-- Form -->
<div class="bg-white rounded-lg shadow p-8 max-w-4xl">
    <form method="POST" action="{{ route('admin.expeditions.update', $expedition) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-2 gap-6">
            <!-- Title -->
            <div class="col-span-2">
                <label for="title" class="block text-sm font-bold text-gray-900 mb-2">Expedition Title *</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $expedition->title) }}"
                    placeholder="e.g., K2 Base Camp Trek"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-bold text-gray-900 mb-2">Location *</label>
                <input
                    type="text"
                    name="location"
                    id="location"
                    value="{{ old('location', $expedition->location) }}"
                    placeholder="e.g., Karakoram Range"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                @error('location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Region -->
            <div>
                <label for="region" class="block text-sm font-bold text-gray-900 mb-2">Region *</label>
                <select
                    name="region"
                    id="region"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                    <option value="">Select Region</option>
                    <option value="Karakoram" {{ old('region', $expedition->region) === 'Karakoram' ? 'selected' : '' }}>Karakoram</option>
                    <option value="Himalayas" {{ old('region', $expedition->region) === 'Himalayas' ? 'selected' : '' }}>Himalayas</option>
                    <option value="Hindu Kush" {{ old('region', $expedition->region) === 'Hindu Kush' ? 'selected' : '' }}>Hindu Kush</option>
                    <option value="Northern Areas" {{ old('region', $expedition->region) === 'Northern Areas' ? 'selected' : '' }}>Northern Areas</option>
                </select>
                @error('region')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Difficulty Level -->
            <div>
                <label for="difficulty_level" class="block text-sm font-bold text-gray-900 mb-2">Difficulty Level *</label>
                <select
                    name="difficulty_level"
                    id="difficulty_level"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                    <option value="">Select Difficulty</option>
                    <option value="beginner" {{ old('difficulty_level', $expedition->difficulty_level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ old('difficulty_level', $expedition->difficulty_level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ old('difficulty_level', $expedition->difficulty_level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                    <option value="expert" {{ old('difficulty_level', $expedition->difficulty_level) === 'expert' ? 'selected' : '' }}>Expert</option>
                </select>
                @error('difficulty_level')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-sm font-bold text-gray-900 mb-2">Start Date *</label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    value="{{ old('start_date', $expedition->start_date->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                @error('start_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-sm font-bold text-gray-900 mb-2">End Date *</label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    value="{{ old('end_date', $expedition->end_date->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                @error('end_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Participants -->
            <div>
                <label for="max_participants" class="block text-sm font-bold text-gray-900 mb-2">Max Participants *</label>
                <input
                    type="number"
                    name="max_participants"
                    id="max_participants"
                    value="{{ old('max_participants', $expedition->max_participants) }}"
                    min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                    required
                >
                @error('max_participants')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permit Required -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="permit_required"
                    id="permit_required"
                    value="1"
                    {{ old('permit_required', $expedition->permit_required) ? 'checked' : '' }}
                    class="h-4 w-4 text-green-600 rounded"
                >
                <label for="permit_required" class="ml-3 text-sm font-bold text-gray-900">
                    Permit Required?
                </label>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-bold text-gray-900 mb-2">Description *</label>
            <textarea
                name="description"
                id="description"
                rows="8"
                placeholder="Detailed description of the expedition..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
                required
            >{{ old('description', $expedition->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Permit Details -->
        <div>
            <label for="permit_details" class="block text-sm font-bold text-gray-900 mb-2">Permit Details (if required)</label>
            <textarea
                name="permit_details"
                id="permit_details"
                rows="4"
                placeholder="Information about permits..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
            >{{ old('permit_details', $expedition->permit_details) }}</textarea>
            @error('permit_details')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4 pt-4">
            <button
                type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold"
            >
                Save Changes
            </button>
            <a
                href="{{ route('admin.expeditions.show', $expedition) }}"
                class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
