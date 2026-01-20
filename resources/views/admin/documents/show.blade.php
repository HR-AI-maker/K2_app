@extends('layouts.admin')

@section('title', 'Review Document')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.documents.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Documents
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Review Document</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content (Left Column) -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Document Preview -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6">Document Preview</h2>

            <div class="bg-gray-100 rounded-lg p-8 text-center min-h-96 flex items-center justify-center">
                @if ($document->document_url)
                    @php
                        $ext = pathinfo($document->document_path, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                        <div class="w-full">
                            <img src="{{ $document->document_url }}" alt="Document Preview" class="max-w-full max-h-96 mx-auto rounded-lg">
                        </div>
                    @elseif ($ext === 'pdf')
                        <div class="text-center">
                            <p class="text-6xl mb-4">📄</p>
                            <p class="text-lg font-semibold text-gray-700 mb-4">PDF Document</p>
                            <a href="{{ $document->document_url }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-block">
                                Open PDF
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-6xl mb-4">📄</p>
                            <p class="text-lg font-semibold text-gray-700 mb-4">Document File</p>
                            <a href="{{ $document->document_url }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-block">
                                Download Document
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center">
                        <p class="text-6xl mb-4">❌</p>
                        <p class="text-lg text-gray-600">Document file not available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Document Information -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6">Document Information</h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Document Type</p>
                    <p class="text-lg font-semibold capitalize">{{ str_replace('_', ' ', $document->document_type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Uploaded</p>
                    <p class="text-lg font-semibold">{{ $document->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Status</p>
                    <p class="text-lg font-semibold">
                        @if ($document->verified_at)
                            <span class="text-green-600">✓ Verified</span>
                        @elseif ($document->rejection_date)
                            <span class="text-red-600">✗ Rejected</span>
                        @else
                            <span class="text-yellow-600">⏳ Pending</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Last Updated</p>
                    <p class="text-lg font-semibold">{{ $document->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            @if ($document->verified_at)
                <div class="mt-6 pt-6 border-t">
                    <p class="text-sm text-gray-600 mb-2">Verified By</p>
                    <p class="font-semibold">{{ $document->verifiedBy->full_name }}</p>
                    <p class="text-sm text-gray-600">{{ $document->verified_at->format('M d, Y H:i') }}</p>
                </div>
            @endif

            @if ($document->rejection_reason)
                <div class="mt-6 pt-6 border-t bg-red-50 p-4 rounded-lg">
                    <p class="text-sm font-bold text-red-900 mb-2">Rejection Reason</p>
                    <p class="text-red-800">{{ $document->rejection_reason }}</p>
                    <p class="text-xs text-red-600 mt-2">Rejected: {{ $document->rejection_date->format('M d, Y H:i') }}</p>
                </div>
            @endif
        </div>

        <!-- Verification Actions -->
        @if (!$document->verified_at && !$document->rejection_date)
            <div class="bg-blue-50 border border-blue-300 rounded-lg p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Verification Actions</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Verify Button -->
                    <form method="POST" action="{{ route('admin.documents.verify', $document) }}">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold flex items-center justify-center gap-2">
                            ✓ Verify Document
                        </button>
                        <p class="text-xs text-gray-600 mt-2">This will approve the document for this user</p>
                    </form>

                    <!-- Reject Button (opens modal) -->
                    <button
                        type="button"
                        onclick="document.getElementById('rejectModal').showModal()"
                        class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold flex items-center justify-center gap-2"
                    >
                        ✗ Reject Document
                    </button>
                </div>
            </div>

            <!-- Reject Modal -->
            <dialog id="rejectModal" class="rounded-lg shadow-lg w-full md:w-1/2 mx-auto">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4">Reject Document</h3>

                    <form method="POST" action="{{ route('admin.documents.reject', $document) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="rejection_reason" class="block text-sm font-bold text-gray-900 mb-2">Reason for Rejection *</label>
                            <textarea
                                name="rejection_reason"
                                id="rejection_reason"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600"
                                placeholder="e.g., Document is blurry, personal information not clearly visible, document appears to be altered..."
                                required
                            ></textarea>
                            <p class="text-xs text-gray-600 mt-2">The user will see this reason and can resubmit the document</p>
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="flex-1 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold"
                            >
                                Reject
                            </button>
                            <button
                                type="button"
                                onclick="document.getElementById('rejectModal').close()"
                                class="flex-1 px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @elseif ($document->rejection_date)
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-8">
                <h2 class="text-2xl font-bold text-yellow-900 mb-6">Reopen for Resubmission</h2>

                <form method="POST" action="{{ route('admin.documents.clearRejection', $document) }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-semibold">
                        Clear Rejection & Allow Resubmission
                    </button>
                    <p class="text-xs text-gray-600 mt-2">This will remove the rejection and allow the user to resubmit the document</p>
                </form>
            </div>
        @endif
    </div>

    <!-- Sidebar (Right Column) -->
    <div class="space-y-8">
        <!-- User Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">User Information</h3>

            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-semibold">{{ $user->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-semibold break-all">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-semibold">{{ $user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Member Since</p>
                    <p class="font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                </div>

                <a href="{{ route('admin.members.show', $user) }}" class="block mt-4 text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                    View Member Profile
                </a>
            </div>
        </div>

        <!-- Membership Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">Membership Status</h3>

            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Tier</p>
                    <p class="font-semibold capitalize">{{ $user->membership_tier ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="font-semibold capitalize">
                        @if ($user->membership_status === 'active')
                            <span class="text-green-600">Active</span>
                        @elseif ($user->membership_status === 'expired')
                            <span class="text-red-600">Expired</span>
                        @elseif ($user->membership_status === 'suspended')
                            <span class="text-orange-600">Suspended</span>
                        @else
                            <span class="text-yellow-600">Pending</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Verified</p>
                    <p class="font-semibold">
                        @if ($user->isVerified())
                            ✓ Yes
                        @else
                            ✗ No
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Documents Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">📋 Documents Status</h3>

            <div class="space-y-2">
                @php
                    $docTypeLabels = [
                        'cnic' => 'CNIC / ID',
                        'passport' => 'Passport',
                        'insurance' => 'Insurance',
                        'medical' => 'Medical',
                    ];
                @endphp

                @foreach ($docTypeLabels as $type => $label)
                    @php
                        $doc = $userDocuments->get($type)?->first();
                    @endphp
                    <div class="flex items-center gap-2 p-2 rounded
                        @if ($doc?->verified_at) bg-green-50
                        @elseif ($doc?->rejection_date) bg-red-50
                        @elseif ($doc) bg-yellow-50
                        @else bg-gray-50 @endif
                    ">
                        @if ($doc?->verified_at)
                            <span class="text-green-600 font-bold">✓</span>
                            <span class="text-sm"><strong>{{ $label }}</strong> - Verified</span>
                        @elseif ($doc?->rejection_date)
                            <span class="text-red-600 font-bold">✗</span>
                            <span class="text-sm"><strong>{{ $label }}</strong> - Rejected</span>
                        @elseif ($doc)
                            <span class="text-yellow-600 font-bold">⏳</span>
                            <span class="text-sm"><strong>{{ $label }}</strong> - Pending</span>
                        @else
                            <span class="text-gray-600 font-bold">—</span>
                            <span class="text-sm text-gray-600"><strong>{{ $label }}</strong> - Not Uploaded</span>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($allDocumentsVerified)
                <div class="mt-4 p-3 bg-green-100 border border-green-300 rounded">
                    <p class="text-sm font-semibold text-green-900">✓ All required documents verified!</p>
                </div>
            @else
                <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded">
                    <p class="text-sm font-semibold text-yellow-900">⏳ Waiting for remaining documents</p>
                </div>
            @endif
        </div>

        <!-- Medical Information -->
        @if ($user->medicalInfo)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">🏥 Medical Info</h3>

                <div class="space-y-2 text-sm">
                    @if ($user->medicalInfo->blood_type)
                        <div>
                            <p class="text-gray-600">Blood Type</p>
                            <p class="font-semibold">{{ $user->medicalInfo->blood_type }}</p>
                        </div>
                    @endif

                    @if ($user->medicalInfo->allergies)
                        <div>
                            <p class="text-gray-600">Allergies</p>
                            <p class="font-semibold">{{ implode(', ', $user->medicalInfo->allergies) }}</p>
                        </div>
                    @endif

                    @if ($user->medicalInfo->emergency_contact_name)
                        <div>
                            <p class="text-gray-600">Emergency Contact</p>
                            <p class="font-semibold">{{ $user->medicalInfo->emergency_contact_name }}</p>
                            <p class="text-gray-600">{{ $user->medicalInfo->emergency_contact_phone }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">Quick Actions</h3>

            <div class="space-y-2">
                <a href="{{ route('admin.members.show', $user) }}" class="block text-center py-2 px-4 border rounded-lg hover:bg-gray-50 text-sm font-semibold">
                    👤 View Profile
                </a>
                <a href="{{ route('admin.documents.index', ['search' => $user->email]) }}" class="block text-center py-2 px-4 border rounded-lg hover:bg-gray-50 text-sm font-semibold">
                    📄 Other Documents
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
