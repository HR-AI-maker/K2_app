@extends('layouts.member')

@section('title', $post->title)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <a href="{{ route('community.index') }}" class="text-purple-100 hover:text-white mb-4 inline-block">
                ← Back to Community
            </a>
            <div class="flex items-center gap-3 mb-4">
                <span class="badge bg-purple-200 text-purple-900">
                    @if ($post->post_type === 'post') 📝 Post
                    @elseif ($post->post_type === 'journal') 📖 Journal
                    @else 📷 Photo
                    @endif
                </span>
                @if ($post->status === 'draft')
                    <span class="badge bg-yellow-200 text-yellow-900">⏳ Pending Approval</span>
                @endif
            </div>
            <h1 class="text-4xl font-bold">{{ $post->title }}</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Post Content -->
            <div class="lg:col-span-2">
                <!-- Post Header -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <!-- Author Info -->
                    <div class="flex items-center justify-between pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ substr($post->user->first_name, 0, 1) }}{{ substr($post->user->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $post->user->full_name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $post->created_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>

                        <!-- Edit/Delete (owner only) -->
                        @if (auth()->check() && $post->user_id === auth()->id())
                            <div class="flex gap-2">
                                <a href="{{ route('community.edit', $post) }}" class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('community.destroy', $post) }}" onsubmit="return confirm('Delete this post?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Meta Info -->
                    <div class="flex gap-4 py-4 text-sm text-gray-600 border-b border-gray-200">
                        <span>📍 {{ $post->region }}</span>
                        <span>📝 {{ strlen($post->content) }} characters</span>
                    </div>

                    <!-- Post Content -->
                    <div class="py-6">
                        <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $post->content }}</p>
                    </div>

                    <!-- Engagement Stats -->
                    <div class="flex gap-6 pt-6 border-t border-gray-200">
                        <button class="flex items-center gap-2 text-gray-600 hover:text-red-600 transition">
                            👍 <span>{{ $post->likes_count ?? 0 }}</span>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition">
                            💬 <span>{{ $post->comments_count ?? 0 }}</span>
                        </button>
                    </div>
                </div>

                <!-- Comments Section (Future) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-6">Comments</h2>
                    <div class="text-center py-8 text-gray-600">
                        <p>Comments feature coming soon!</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Author Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">About the Author</h3>

                    <div class="text-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3">
                            {{ substr($post->user->first_name, 0, 1) }}{{ substr($post->user->last_name, 0, 1) }}
                        </div>
                        <p class="font-semibold text-lg">{{ $post->user->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $post->user->email }}</p>
                    </div>

                    <div class="space-y-2 border-t border-gray-200 pt-4">
                        <p class="text-sm text-gray-600">
                            <strong>Member Since:</strong> {{ $post->user->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <strong>Membership Status:</strong> <span class="capitalize">{{ $post->user->membership_status ?? 'pending' }}</span>
                        </p>
                        @if ($post->user->membership_tier)
                            <p class="text-sm text-gray-600">
                                <strong>Tier:</strong> <span class="capitalize">{{ $post->user->membership_tier }}</span>
                            </p>
                        @endif
                    </div>

                    <a href="{{ route('admin.members.show', $post->user) }}" class="btn-secondary w-full mt-4">
                        View Profile
                    </a>
                </div>

                <!-- Post Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Post Information</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-600 uppercase mb-1">Type</p>
                            <p class="font-semibold capitalize">
                                @if ($post->post_type === 'post') 📝 Post
                                @elseif ($post->post_type === 'journal') 📖 Journal Entry
                                @else 📷 Photo Gallery
                                @endif
                            </p>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs text-gray-600 uppercase mb-1">Region</p>
                            <p class="font-semibold">{{ $post->region }}</p>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs text-gray-600 uppercase mb-1">Status</p>
                            <p class="font-semibold capitalize">
                                @if ($post->status === 'published')
                                    <span class="text-green-600">✓ Published</span>
                                @elseif ($post->status === 'approved')
                                    <span class="text-green-600">✓ Approved</span>
                                @elseif ($post->status === 'draft')
                                    <span class="text-yellow-600">⏳ Pending</span>
                                @else
                                    <span class="text-red-600">✗ {{ ucfirst($post->status) }}</span>
                                @endif
                            </p>
                        </div>

                        @if ($post->approved_at)
                            <div class="border-t border-gray-200 pt-3">
                                <p class="text-xs text-gray-600 uppercase mb-1">Approved By</p>
                                <p class="font-semibold text-sm">{{ $post->approvedBy->full_name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-600">{{ $post->approved_at->format('M d, Y') }}</p>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs text-gray-600 uppercase mb-1">Created</p>
                            <p class="text-sm">{{ $post->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Similar Posts -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Similar Posts</h3>

                    <div class="space-y-3">
                        @php
                            $similar = \App\Models\CommunityPost::where('region', $post->region)
                                ->where('id', '!=', $post->id)
                                ->where('status', 'published')
                                ->orWhere('status', 'approved')
                                ->limit(5)
                                ->get();
                        @endphp

                        @if ($similar->count() > 0)
                            @foreach ($similar as $item)
                                <a href="{{ route('community.show', $item) }}" class="block p-3 border border-gray-200 rounded hover:bg-gray-50 transition">
                                    <p class="font-semibold text-sm line-clamp-1">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $item->created_at->diffForHumans() }}</p>
                                </a>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-600">No similar posts found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

