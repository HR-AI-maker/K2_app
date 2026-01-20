@extends('layouts.admin')

@section('title', 'Edit Badge: ' . $badge->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.badges.show', $badge) }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Badge
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Edit Badge</h1>
    <p class="text-gray-600 mt-2">{{ $badge->name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <form method="POST" action="{{ route('admin.badges.update', $badge) }}" class="space-y-6">
        @csrf
        @method('PATCH')

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
                    value="{{ old('name', $badge->name) }}"
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
                    <option value="bronze" {{ old('tier', $badge->tier) === 'bronze' ? 'selected' : '' }}>Bronze (Entry Level)</option>
                    <option value="silver" {{ old('tier', $badge->tier) === 'silver' ? 'selected' : '' }}>Silver (Intermediate)</option>
                    <option value="gold" {{ old('tier', $badge->tier) === 'gold' ? 'selected' : '' }}>Gold (Advanced)</option>
                    <option value="platinum" {{ old('tier', $badge->tier) === 'platinum' ? 'selected' : '' }}>Platinum (Elite)</option>
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
                class="input @error('description') input-error @enderror"
                required
            >{{ old('description', $badge->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icon Path -->
        <div>
            <label for="icon_path" class="block text-sm font-semibold text-gray-900 mb-2">
                Badge Icon (Emoji) *
            </label>
            <div class="flex gap-4 items-start">
                <input
                    type="text"
                    id="icon_path"
                    name="icon_path"
                    value="{{ old('icon_path', $badge->icon_path) }}"
                    maxlength="10"
                    class="input @error('icon_path') input-error @enderror flex-1"
                    required
                >
                <div class="text-6xl">{{ $badge->icon_path }}</div>
            </div>
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
                @foreach ($criteriaOptions as $key => $label)
                    <option value="{{ $key }}" {{ old('criteria', $badge->criteria) === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('criteria')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="btn-primary flex-1">
                ✓ Update Badge
            </button>
            <a href="{{ route('admin.badges.show', $badge) }}" class="btn-secondary flex-1">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
