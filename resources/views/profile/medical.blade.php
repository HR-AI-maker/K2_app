@extends('layouts.app')

@section('title', 'Medical Information')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">Medical Information</h1>
            <p class="text-gray-600 mt-2">Important for your safety during activities</p>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" action="{{ route('profile.medical.update') }}" class="space-y-6">
                @csrf

                <!-- Blood Type -->
                <div>
                    <label for="blood_type" class="block text-sm font-bold text-gray-900 mb-2">Blood Type *</label>
                    <select
                        name="blood_type"
                        id="blood_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('blood_type') border-red-600 @enderror"
                        required
                    >
                        <option value="">Select your blood type</option>
                        <option value="O+" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'O-' ? 'selected' : '' }}>O-</option>
                        <option value="A+" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_type', $medicalInfo->blood_type ?? '') === 'AB-' ? 'selected' : '' }}>AB-</option>
                    </select>
                    @error('blood_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Allergies -->
                <div>
                    <label for="allergies" class="block text-sm font-bold text-gray-900 mb-2">Allergies</label>
                    <p class="text-xs text-gray-600 mb-2">List any allergies (medications, food, etc.) separated by commas</p>
                    <textarea
                        name="allergies[]"
                        id="allergies"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('allergies') border-red-600 @enderror"
                        placeholder="e.g., Penicillin, Peanuts, Sulfa drugs"
                    >{{ old('allergies', $medicalInfo->allergies ? implode(', ', $medicalInfo->allergies) : '') }}</textarea>
                    @error('allergies')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medical Conditions -->
                <div>
                    <label for="medical_conditions" class="block text-sm font-bold text-gray-900 mb-2">Medical Conditions</label>
                    <p class="text-xs text-gray-600 mb-2">List any chronic conditions or health concerns</p>
                    <textarea
                        name="medical_conditions[]"
                        id="medical_conditions"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('medical_conditions') border-red-600 @enderror"
                        placeholder="e.g., Asthma, Diabetes, High Blood Pressure"
                    >{{ old('medical_conditions', $medicalInfo->medical_conditions ? implode(', ', $medicalInfo->medical_conditions) : '') }}</textarea>
                    @error('medical_conditions')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emergency Contact -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="font-bold text-yellow-900 mb-4">Emergency Contact</h3>

                    <div class="space-y-4">
                        <!-- Emergency Contact Name -->
                        <div>
                            <label for="emergency_contact_name" class="block text-sm font-bold text-gray-900 mb-2">Name *</label>
                            <input
                                type="text"
                                name="emergency_contact_name"
                                id="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $medicalInfo->emergency_contact_name ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('emergency_contact_name') border-red-600 @enderror"
                                required
                            >
                            @error('emergency_contact_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Emergency Contact Phone -->
                        <div>
                            <label for="emergency_contact_phone" class="block text-sm font-bold text-gray-900 mb-2">Phone Number *</label>
                            <input
                                type="tel"
                                name="emergency_contact_phone"
                                id="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone', $medicalInfo->emergency_contact_phone ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('emergency_contact_phone') border-red-600 @enderror"
                                placeholder="+92 3XX XXXXXXX"
                                required
                            >
                            @error('emergency_contact_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Emergency Contact Relationship -->
                        <div>
                            <label for="emergency_contact_relationship" class="block text-sm font-bold text-gray-900 mb-2">Relationship *</label>
                            <select
                                name="emergency_contact_relationship"
                                id="emergency_contact_relationship"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('emergency_contact_relationship') border-red-600 @enderror"
                                required
                            >
                                <option value="">Select relationship</option>
                                <option value="Mother" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Father" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Spouse" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Sibling" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                <option value="Friend" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Friend' ? 'selected' : '' }}>Friend</option>
                                <option value="Other" {{ old('emergency_contact_relationship', $medicalInfo->emergency_contact_relationship ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('emergency_contact_relationship')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Insurance -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-bold text-blue-900 mb-4">Travel Insurance</h3>

                    <div class="space-y-4">
                        <!-- Insurance Provider -->
                        <div>
                            <label for="insurance_provider" class="block text-sm font-bold text-gray-900 mb-2">Provider *</label>
                            <input
                                type="text"
                                name="insurance_provider"
                                id="insurance_provider"
                                value="{{ old('insurance_provider', $medicalInfo->insurance_provider ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('insurance_provider') border-red-600 @enderror"
                                placeholder="e.g., AIG, Allianz, CHUBB"
                                required
                            >
                            @error('insurance_provider')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Policy Number -->
                        <div>
                            <label for="insurance_policy_number" class="block text-sm font-bold text-gray-900 mb-2">Policy Number *</label>
                            <input
                                type="text"
                                name="insurance_policy_number"
                                id="insurance_policy_number"
                                value="{{ old('insurance_policy_number', $medicalInfo->insurance_policy_number ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('insurance_policy_number') border-red-600 @enderror"
                                required
                            >
                            @error('insurance_policy_number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="insurance_expiry" class="block text-sm font-bold text-gray-900 mb-2">Expiry Date *</label>
                            <input
                                type="date"
                                name="insurance_expiry"
                                id="insurance_expiry"
                                value="{{ old('insurance_expiry', $medicalInfo->insurance_expiry ? $medicalInfo->insurance_expiry->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('insurance_expiry') border-red-600 @enderror"
                                required
                            >
                            @error('insurance_expiry')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-4">
                    <button
                        type="submit"
                        class="btn-primary flex-1"
                    >
                        Save Medical Information
                    </button>
                    <a
                        href="{{ route('dashboard') }}"
                        class="btn px-6 py-2 bg-gray-600 text-white hover:bg-gray-700 flex items-center justify-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Privacy Notice -->
        <div class="mt-8 card bg-green-50 border-l-4 border-green-600">
            <p class="text-sm text-green-900">
                🔒 <strong>Your medical information is encrypted and secure.</strong> It will only be accessed by authorized Pak Alpine staff during emergencies or for safety purposes.
            </p>
        </div>
    </div>
</div>
@endsection
