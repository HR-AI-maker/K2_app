@extends('layouts.admin')

@section('title', 'Create Badge')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.badges.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Badges
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Create New Badge</h1>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <form method="POST" action="{{ route('admin.badges.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Badge Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                    Badge Name *
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g., First Step"
                    class="input @error('name') input-error @enderror"
                    required
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tier -->
            <div>
                <label for="tier" class="block text-sm font-semibold text-gray-900 mb-2">
                    Tier *
                </label>
                <select
                    id="tier"
                    name="tier"
                    class="input @error('tier') input-error @enderror"
                    required
                >
                    <option value="">-- Select Tier --</option>
                    <option value="bronze" {{ old('tier') === 'bronze' ? 'selected' : '' }}>Bronze (Entry Level)</option>
                    <option value="silver" {{ old('tier') === 'silver' ? 'selected' : '' }}>Silver (Intermediate)</option>
                    <option value="gold" {{ old('tier') === 'gold' ? 'selected' : '' }}>Gold (Advanced)</option>
                    <option value="platinum" {{ old('tier') === 'platinum' ? 'selected' : '' }}>Platinum (Elite)</option>
                </select>
                @error('tier')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                Description *
            </label>
            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Describe what this badge represents and why users should earn it..."
                class="input @error('description') input-error @enderror"
                required
            >{{ old('description') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Minimum 10 characters</p>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icon Path (Emoji or Icon Code) -->
        <div>
            <label for="icon_path" class="block text-sm font-semibold text-gray-900 mb-2">
                Badge Icon (Emoji) *
            </label>
            <input
                type="text"
                id="icon_path"
                name="icon_path"
                value="{{ old('icon_path') }}"
                placeholder="e.g., 🏆, ⭐, 🎉, 🚀"
                maxlength="10"
                class="input @error('icon_path') input-error @enderror"
                required
            >
            <p class="text-xs text-gray-500 mt-1">Enter an emoji or icon code (e.g., 🏆 for trophy)</p>
            @error('icon_path')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Earning Criteria -->
        <div>
            <label for="criteria" class="block text-sm font-semibold text-gray-900 mb-2">
                Earning Criteria *
            </label>
            <select
                id="criteria"
                name="criteria"
                class="input @error('criteria') input-error @enderror"
                required
            >
                <option value="">-- Select Criteria --</option>
                @foreach ($criteriaOptions as $key => $label)
                    <option value="{{ $key }}" {{ old('criteria') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Select the condition that users must meet to earn this badge</p>
            @error('criteria')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Badge Tier Guide -->
        <div class="bg-blue-50 border border-blue-300 rounded-lg p-6">
            <h3 class="font-semibold text-blue-900 mb-3">💡 Badge Tier Guide</h3>
            <div class="space-y-2 text-sm text-blue-800">
                <p><strong>Bronze:</strong> Entry-level achievements (first profile, first event, safety first)</p>
                <p><strong>Silver:</strong> Intermediate achievements (active member, verified member, community contributor)</p>
                <p><strong>Gold:</strong> Advanced achievements (veteran member, premium supporter, event participator)</p>
                <p><strong>Platinum:</strong> Elite achievements (expedition explorer, exclusive/rare criteria)</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="btn-primary flex-1">
                ✓ Create Badge
            </button>
            <a href="{{ route('admin.badges.index') }}" class="btn-secondary flex-1">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
