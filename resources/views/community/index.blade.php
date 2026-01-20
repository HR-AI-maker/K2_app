@extends('layouts.app')

@section('title', 'Community Posts')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Community Posts</h1>
                    <p class="text-purple-100">Share your alpine experiences and connect with fellow climbers</p>
                </div>
                @auth
                    <a href="{{ route('community.create') }}" class="btn-primary">
                        ✍️ Write a Post
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        ✍️ Login to Write
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <form method="GET" class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Title, content..."
                        class="input"
                    >
                </div>

                <!-- Post Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="post_type" class="input">
                        <option value="">All Types</option>
                        <option value="post" {{ $currentPostType === 'post' ? 'selected' : '' }}>Post</option>
                        <option value="journal" {{ $currentPostType === 'journal' ? 'selected' : '' }}>Journal</option>
                        <option value="photo" {{ $currentPostType === 'photo' ? 'selected' : '' }}>Photo</option>
                    </select>
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <select name="region" class="input">
                        <option value="">All Regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" {{ $currentRegion === $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort</label>
                    <select name="sort_by" class="input">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Newest</option>
                        <option value="likes_count" {{ request('sort_by') === 'likes_count' ? 'selected' : '' }}>Most Popular</option>
                        <option value="comments_count" {{ request('sort_by') === 'comments_count' ? 'selected' : '' }}>Most Discussed</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>

        <!-- Posts Grid -->
        @if ($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($posts as $post)
                    <a href="{{ route('community.show', $post) }}" class="card hover:shadow-lg transition-shadow hover:scale-105">
                        <!-- Post Type Badge & Author -->
                        <div class="flex justify-between items-start mb-3">
                            <span class="badge
                                @if ($post->post_type === 'post') bg-blue-100 text-blue-800
                                @elseif ($post->post_type === 'journal') bg-green-100 text-green-800
                                @else bg-orange-100 text-orange-800
                                @endif">
                                @if ($post->post_type === 'post') 📝 Post
                                @elseif ($post->post_type === 'journal') 📖 Journal
                                @else 📷 Photo
                                @endif
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            {{ $post->title }}
                        </h3>

                        <!-- Region -->
                        <p class="text-sm text-gray-600 mb-2">
                            📍 {{ $post->region }}
                        </p>

                        <!-- Content Preview -->
                        <p class="text-sm text-gray-700 mb-3 line-clamp-3">
                            {{ $post->content }}
                        </p>

                        <!-- Author & Date -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                                <div class="text-xs">
                                    <p class="font-semibold text-gray-900">{{ $post->user->first_name }}</p>
                                    <p class="text-gray-600">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Engagement Stats -->
                        <div class="flex gap-4 mt-3 pt-3 border-t border-gray-200 text-sm text-gray-600">
                            <span>👍 {{ $post->likes_count ?? 0 }}</span>
                            <span>💬 {{ $post->comments_count ?? 0 }}</span>
                        </div>

                        <!-- Approval Badge -->
                        @if ($post->status === 'draft')
                            <div class="mt-3 p-2 bg-yellow-100 rounded text-xs text-yellow-800 font-semibold">
                                ⏳ Pending Approval
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-6xl mb-4">📭</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Posts Found</h3>
                <p class="text-gray-600 mb-6">Be the first to share your alpine adventure!</p>
                @auth
                    <a href="{{ route('community.create') }}" class="btn-primary">
                        ✍️ Create a Post
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        Login to Share
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
