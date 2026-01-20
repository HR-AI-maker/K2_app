@extends('layouts.app')

@section('title', 'Upload Documents')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Dashboard</a>
            <h1 class="text-4xl font-bold text-gray-900">Upload Documents</h1>
            <p class="text-gray-600 mt-2">Submit required documents for verification</p>
        </div>

        <!-- Upload Form -->
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-6">📄 Upload New Document</h2>

            <form method="POST" action="{{ route('profile.documents.upload') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Document Type -->
                <div>
                    <label for="document_type" class="block text-sm font-bold text-gray-900 mb-2">Document Type *</label>
                    <select
                        name="document_type"
                        id="document_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 @error('document_type') border-red-600 @enderror"
                        required
                    >
                        <option value="">Select document type</option>
                        <option value="cnic" {{ old('document_type') === 'cnic' ? 'selected' : '' }}>CNIC / ID Card</option>
                        <option value="passport" {{ old('document_type') === 'passport' ? 'selected' : '' }}>Passport</option>
                        <option value="visa" {{ old('document_type') === 'visa' ? 'selected' : '' }}>Visa</option>
                        <option value="insurance" {{ old('document_type') === 'insurance' ? 'selected' : '' }}>Travel Insurance</option>
                        <option value="medical" {{ old('document_type') === 'medical' ? 'selected' : '' }}>Medical Certificate</option>
                    </select>
                    @error('document_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label for="document_file" class="block text-sm font-bold text-gray-900 mb-2">Document File *</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-600 transition"
                         x-data="{ dragover: false }"
                         @dragover.prevent="dragover = true"
                         @dragleave.prevent="dragover = false"
                         @drop.prevent="dragover = false; document.getElementById('document_file').files = $event.dataTransfer.files"
                         :class="{ 'border-blue-600 bg-blue-50': dragover }">
                        <p class="text-4xl mb-2">📤</p>
                        <p class="text-gray-700 font-semibold mb-1">Drag and drop your file here</p>
                        <p class="text-gray-600 text-sm mb-4">or click to select</p>
                        <input
                            type="file"
                            name="document_file"
                            id="document_file"
                            class="hidden"
                            accept=".pdf,.jpg,.jpeg,.png"
                            required
                            @change="document.querySelector('p:last-of-type').textContent = this.files[0]?.name || 'No file selected'"
                        >
                        <button type="button" onclick="document.getElementById('document_file').click()" class="btn-primary">
                            Select File
                        </button>
                        <p class="text-xs text-gray-600 mt-4">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                    @error('document_file')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="btn-primary flex-1"
                    >
                        Upload Document
                    </button>
                </div>
            </form>
        </div>

        <!-- Documents List -->
        <div class="card">
            <h2 class="text-2xl font-bold mb-6">📋 Your Documents</h2>

            @if ($documents->count() > 0)
                <div class="space-y-4">
                    @foreach ($documents as $document)
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold capitalize">{{ str_replace('_', ' ', $document->document_type) }}</p>
                                    <p class="text-sm text-gray-600">Uploaded {{ $document->created_at->diffForHumans() }}</p>

                                    <!-- Verification Status -->
                                    <div class="mt-2">
                                        @if ($document->verified_at)
                                            <span class="badge bg-green-100 text-green-800">
                                                ✓ Verified {{ $document->verified_at->format('M d, Y') }}
                                            </span>
                                        @elseif ($document->rejection_reason)
                                            <span class="badge bg-red-100 text-red-800">
                                                ✗ Rejected
                                            </span>
                                            @if ($document->rejection_reason)
                                                <p class="text-xs text-red-700 mt-2">
                                                    <strong>Reason:</strong> {{ $document->rejection_reason }}
                                                </p>
                                            @endif
                                        @else
                                            <span class="badge bg-yellow-100 text-yellow-800">
                                                ⏳ Pending Review
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 ml-4">
                                    @if ($document->document_url)
                                        <a href="{{ $document->document_url }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                            View
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('profile.documents.delete', $document) }}" class="inline"
                                          onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-2xl mb-2">📭</p>
                    <p class="text-gray-600">No documents uploaded yet</p>
                    <p class="text-sm text-gray-500 mt-2">Start by uploading your ID or passport above</p>
                </div>
            @endif
        </div>

        <!-- Document Requirements -->
        <div class="mt-8 card bg-blue-50 border-l-4 border-blue-600">
            <h3 class="text-lg font-bold text-blue-900 mb-4">📌 Document Requirements</h3>
            <div class="space-y-3 text-sm text-blue-900">
                <div class="flex items-start gap-2">
                    <span class="text-lg">📇</span>
                    <div>
                        <p class="font-semibold">CNIC / ID Card</p>
                        <p class="text-blue-800">National ID or government-issued ID card</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">🛂</span>
                    <div>
                        <p class="font-semibold">Passport</p>
                        <p class="text-blue-800">Valid passport for international expeditions</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">✈️</span>
                    <div>
                        <p class="font-semibold">Travel Insurance</p>
                        <p class="text-blue-800">Valid travel/mountaineering insurance policy</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-lg">🏥</span>
                    <div>
                        <p class="font-semibold">Medical Certificate</p>
                        <p class="text-blue-800">Medical fitness certificate from a doctor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
