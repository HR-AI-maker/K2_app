@extends('layouts.admin')

@section('title', 'Document Verification')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">📄 Document Verification</h1>
            <p class="text-gray-600 mt-2">Review and verify user-submitted documents</p>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'pending' ? 'ring-2 ring-yellow-600' : '' }}">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'verified' ? 'ring-2 ring-green-600' : '' }}">
        <p class="text-gray-600 text-sm">Verified</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'rejected' ? 'ring-2 ring-red-600' : '' }}">
        <p class="text-gray-600 text-sm">Rejected</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.documents.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $currentStatus === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ $currentStatus === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>All</option>
                </select>
            </div>

            <!-- Document Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                <select name="document_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="cnic" {{ request('document_type') === 'cnic' ? 'selected' : '' }}>CNIC</option>
                    <option value="passport" {{ request('document_type') === 'passport' ? 'selected' : '' }}>Passport</option>
                    <option value="visa" {{ request('document_type') === 'visa' ? 'selected' : '' }}>Visa</option>
                    <option value="insurance" {{ request('document_type') === 'insurance' ? 'selected' : '' }}>Insurance</option>
                    <option value="medical" {{ request('document_type') === 'medical' ? 'selected' : '' }}>Medical</option>
                </select>
            </div>

            <!-- Search by User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search User</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Email, name..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="updated_at" {{ request('sort_by') === 'updated_at' ? 'selected' : '' }}>Recently Updated</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Documents Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($documents->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Document Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uploaded</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Verified By</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($documents as $document)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold">{{ $document->user->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $document->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm capitalize">
                            <span class="badge bg-blue-100 text-blue-800">
                                {{ str_replace('_', ' ', $document->document_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $document->created_at->format('M d, Y') }}<br>
                            <span class="text-gray-600">{{ $document->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($document->verified_at)
                                <span class="badge bg-green-100 text-green-800">
                                    ✓ Verified
                                </span>
                            @elseif ($document->rejection_date)
                                <span class="badge bg-red-100 text-red-800">
                                    ✗ Rejected
                                </span>
                            @else
                                <span class="badge bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($document->verifiedBy)
                                <p class="text-sm">{{ $document->verifiedBy->full_name }}</p>
                                <p class="text-gray-600">{{ $document->verified_at->format('M d, Y') }}</p>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm">
                            <a href="{{ route('admin.documents.show', $document) }}" class="text-blue-600 hover:underline">
                                Review
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No documents found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see documents</p>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $documents->links() }}
</div>
@endsection
