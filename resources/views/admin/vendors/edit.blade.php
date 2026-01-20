@extends('layouts.admin')

@section('title', 'Edit Vendor: ' . $vendor->business_name)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Vendor
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Edit Vendor</h1>
    <p class="text-gray-600 mt-2">{{ $vendor->business_name }}</p>
</div>

<div class="bg-white rounded-lg shadow p-8">
    <form method="POST" action="{{ route('admin.vendors.update', $vendor) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Business Name -->
            <div>
                <label for="business_name" class="block text-sm font-semibold text-gray-900 mb-2">
                    Business Name *
                </label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    value="{{ old('business_name', $vendor->business_name) }}"
                    class="input @error('business_name') input-error @enderror"
                    required
                >
                @error('business_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Person -->
            <div>
                <label for="contact_person" class="block text-sm font-semibold text-gray-900 mb-2">
                    Contact Person *
                </label>
                <input
                    type="text"
                    id="contact_person"
                    name="contact_person"
                    value="{{ old('contact_person', $vendor->contact_person) }}"
                    class="input @error('contact_person') input-error @enderror"
                    required
                >
                @error('contact_person')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                    Email *
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $vendor->email) }}"
                    class="input @error('email') input-error @enderror"
                    required
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                    Phone *
                </label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $vendor->phone) }}"
                    class="input @error('phone') input-error @enderror"
                    required
                >
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Business Type -->
            <div>
                <label for="business_type" class="block text-sm font-semibold text-gray-900 mb-2">
                    Business Type *
                </label>
                <select
                    id="business_type"
                    name="business_type"
                    class="input @error('business_type') input-error @enderror"
                    required
                >
                    <option value="guide" {{ old('business_type', $vendor->business_type) === 'guide' ? 'selected' : '' }}>Guide</option>
                    <option value="transport" {{ old('business_type', $vendor->business_type) === 'transport' ? 'selected' : '' }}>Transport</option>
                    <option value="lodging" {{ old('business_type', $vendor->business_type) === 'lodging' ? 'selected' : '' }}>Lodging</option>
                    <option value="equipment" {{ old('business_type', $vendor->business_type) === 'equipment' ? 'selected' : '' }}>Equipment</option>
                    <option value="other" {{ old('business_type', $vendor->business_type) === 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('business_type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Certification Status -->
            <div class="flex items-center">
                <label for="is_certified" class="flex items-center">
                    <input
                        type="checkbox"
                        id="is_certified"
                        name="is_certified"
                        value="1"
                        {{ old('is_certified', $vendor->is_certified) ? 'checked' : '' }}
                        class="rounded"
                    >
                    <span class="ml-2 text-sm font-semibold text-gray-900">Certified Vendor</span>
                </label>
            </div>
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">
                Address *
            </label>
            <input
                type="text"
                id="address"
                name="address"
                value="{{ old('address', $vendor->address) }}"
                placeholder="City, Region, Country"
                class="input @error('address') input-error @enderror"
                required
            >
            @error('address')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                Description *
            </label>
            <textarea
                id="description"
                name="description"
                rows="6"
                placeholder="Describe the vendor's services, experience, and specialties..."
                class="input @error('description') input-error @enderror"
                required
            >{{ old('description', $vendor->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Certification Details -->
        <div>
            <label for="certification_details" class="block text-sm font-semibold text-gray-900 mb-2">
                Certification Details (Optional)
            </label>
            <textarea
                id="certification_details"
                name="certification_details"
                rows="4"
                placeholder="List certifications, licenses, or credentials..."
                class="input @error('certification_details') input-error @enderror"
            >{{ old('certification_details', $vendor->certification_details) }}</textarea>
            @error('certification_details')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="btn-primary flex-1">
                ✓ Update Vendor
            </button>
            <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn-secondary flex-1">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
