@extends('layouts.admin')

@section('title', $expedition->title . ' - Applications')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $expedition->title }}</h1>
            <p class="text-gray-600 mt-2">Expedition Applications</p>
        </div>
        <a href="{{ route('admin.expeditions.show', $expedition) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Expedition
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Total</p>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['pending'] + $stats['approved'] + $stats['rejected'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Pending</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Approved</p>
        <p class="text-3xl font-bold text-green-600">{{ $stats['approved'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-600 mb-2">Rejected</p>
        <p class="text-3xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <form method="GET" class="flex gap-4">
        <div class="flex-1">
            <input
                type="text"
                name="search"
                placeholder="Search by email or name..."
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600"
            >
        </div>
        <div class="w-48">
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Filter
        </button>
    </form>
</div>

<!-- Applications Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Applicant</th>
                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Email</th>
                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Status</th>
                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Applied Date</th>
                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.members.show', $application->user) }}" class="text-blue-600 hover:underline">
                            {{ $application->user->full_name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $application->user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($application->status === 'approved') bg-green-100 text-green-800
                            @elseif($application->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($application->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst($application->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $application->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm flex gap-2">
                        @if($application->status === 'pending')
                            <form method="POST" action="{{ route('admin.expeditions.approveApplication', $application) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                    Approve
                                </button>
                            </form>
                            <button
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs"
                                onclick="showRejectModal({{ $application->id }}, '{{ $application->user->full_name }}')"
                            >
                                Reject
                            </button>
                        @else
                            <span class="text-gray-500 text-xs">{{ ucfirst($application->status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-600">
                        No applications found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $applications->links() }}
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Application</h3>
        <p id="rejectMessage" class="text-gray-600 mb-6"></p>

        <form id="rejectForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="rejected_reason" class="block text-sm font-bold text-gray-900 mb-2">Reason for Rejection</label>
                <textarea
                    name="rejected_reason"
                    id="rejected_reason"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600"
                    placeholder="Provide a reason for rejection..."
                    required
                ></textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Reject Application
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(applicationId, applicantName) {
    document.getElementById('rejectMessage').textContent = `Are you sure you want to reject ${applicantName}'s application?`;
    document.getElementById('rejectForm').action = `/admin/expeditions/${applicationId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejected_reason').value = '';
}
</script>
@endsection
