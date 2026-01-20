@extends('layouts.admin')

@section('title', 'Community Moderation')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">💬 Community Moderation</h1>
            <p class="text-gray-600 mt-2">Review and moderate user-created posts</p>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'draft' ? 'ring-2 ring-yellow-600' : '' }}">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['draft'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'published' ? 'ring-2 ring-green-600' : '' }}">
        <p class="text-gray-600 text-sm">Published</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center {{ $currentStatus === 'hidden' ? 'ring-2 ring-red-600' : '' }}">
        <p class="text-gray-600 text-sm">Hidden</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['hidden'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.community.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="hidden" {{ $currentStatus === 'hidden' ? 'selected' : '' }}>Hidden</option>
                    <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>All</option>
                </select>
            </div>

            <!-- Post Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                <select name="post_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="">All Types</option>
                    <option value="post" {{ $currentPostType === 'post' ? 'selected' : '' }}>Post</option>
                    <option value="journal" {{ $currentPostType === 'journal' ? 'selected' : '' }}>Journal</option>
                    <option value="photo" {{ $currentPostType === 'photo' ? 'selected' : '' }}>Photo</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Title, author, region..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600"
                >
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                    <option value="likes_count" {{ request('sort_by') === 'likes_count' ? 'selected' : '' }}>Most Popular</option>
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

<!-- Posts Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if ($posts->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Author</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Region</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Created</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold line-clamp-1 max-w-xs">{{ $post->title }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-sm">{{ $post->user->full_name }}</p>
                                <p class="text-xs text-gray-600">{{ $post->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="badge
                                @if ($post->post_type === 'post') bg-blue-100 text-blue-800
                                @elseif ($post->post_type === 'journal') bg-green-100 text-green-800
                                @else bg-orange-100 text-orange-800
                                @endif">
                                @if ($post->post_type === 'post') Post
                                @elseif ($post->post_type === 'journal') Journal
                                @else Photo
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $post->region }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($post->status === 'draft')
                                <span class="badge bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                            @elseif ($post->status === 'published' || $post->status === 'approved')
                                <span class="badge bg-green-100 text-green-800">
                                    ✓ Published
                                </span>
                            @elseif ($post->status === 'hidden')
                                <span class="badge bg-red-100 text-red-800">
                                    ✗ Hidden
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $post->created_at->format('M d, Y') }}<br>
                            <span class="text-gray-600">{{ $post->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-y-1">
                            @if ($post->status === 'draft')
                                <form method="POST" action="{{ route('admin.community.approve', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 block w-full text-center">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            @if ($post->status !== 'hidden')
                                <form method="POST" action="{{ route('admin.community.hide', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 block w-full text-center">
                                        Hide
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.community.unhide', $post) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 block w-full text-center">
                                        Unhide
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.community.destroy', $post) }}" onsubmit="return confirm('Delete this post?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 block w-full text-center">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No posts found</p>
            <p class="text-sm text-gray-500 mt-2">Adjust your filters to see posts</p>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $posts->links() }}
</div>
@endsection
