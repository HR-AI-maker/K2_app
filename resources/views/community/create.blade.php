@extends('layouts.member')

@section('title', 'Create Community Post')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
        <div class="max-w-2xl mx-auto px-4">
            <a href="{{ route('community.index') }}" class="text-purple-100 hover:text-white mb-4 inline-block">
                ← Back to Community
            </a>
            <h1 class="text-4xl font-bold mb-2">Share Your Alpine Experience</h1>
            <p class="text-purple-100">Create a post and connect with fellow climbers</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow p-8">
            <form method="POST" action="{{ route('community.store') }}" class="space-y-6">
                @csrf

                <!-- Post Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Post Title *
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Give your post a compelling title"
                        maxlength="200"
                        class="input @error('title') input-error @enderror"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">Maximum 200 characters</p>
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Post Type -->
                <div>
                    <label for="post_type" class="block text-sm font-semibold text-gray-900 mb-2">
                        Post Type *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Post Option -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition
                            @if (old('post_type') === 'post' || !old('post_type')) border-blue-600 bg-blue-50 @endif">
                            <input
                                type="radio"
                                name="post_type"
                                value="post"
                                {{ old('post_type') === 'post' || !old('post_type') ? 'checked' : '' }}
                                class="mr-3"
                            >
                            <div>
                                <p class="font-semibold text-gray-900">📝 Post</p>
                                <p class="text-xs text-gray-600">Share thoughts and updates</p>
                            </div>
                        </label>

                        <!-- Journal Option -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition
                            @if (old('post_type') === 'journal') border-blue-600 bg-blue-50 @endif">
                            <input
                                type="radio"
                                name="post_type"
                                value="journal"
                                {{ old('post_type') === 'journal' ? 'checked' : '' }}
                                class="mr-3"
                            >
                            <div>
                                <p class="font-semibold text-gray-900">📖 Journal</p>
                                <p class="text-xs text-gray-600">Write detailed journey entries</p>
                            </div>
                        </label>

                        <!-- Photo Option -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition
                            @if (old('post_type') === 'photo') border-blue-600 bg-blue-50 @endif">
                            <input
                                type="radio"
                                name="post_type"
                                value="photo"
                                {{ old('post_type') === 'photo' ? 'checked' : '' }}
                                class="mr-3"
                            >
                            <div>
                                <p class="font-semibold text-gray-900">📷 Photo</p>
                                <p class="text-xs text-gray-600">Share photo collections</p>
                            </div>
                        </label>
                    </div>
                    @error('post_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Region -->
                <div>
                    <label for="region" class="block text-sm font-semibold text-gray-900 mb-2">
                        Region *
                    </label>
                    <input
                        type="text"
                        id="region"
                        name="region"
                        value="{{ old('region') }}"
                        placeholder="e.g., Hunza, Gilgit, Swat Valley, K2 Base Camp"
                        maxlength="100"
                        class="input @error('region') input-error @enderror"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">Where is your post about?</p>
                    @error('region')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-900 mb-2">
                        Content *
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="12"
                        placeholder="Share your experience, tips, photos descriptions, or stories. Be detailed and engaging!"
                        class="input @error('content') input-error @enderror"
                        required
                    >{{ old('content') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimum 10 characters | You can use plain text or simple formatting</p>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guidelines -->
                <div class="bg-blue-50 border border-blue-300 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2">📋 Community Guidelines</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>✓ Be respectful and constructive</li>
                        <li>✓ Share accurate information</li>
                        <li>✓ No spam or promotional content</li>
                        <li>✓ Posts pending admin approval before publishing</li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1">
                        ✍️ Create Post
                    </button>
                    <a href="{{ route('community.index') }}" class="btn-secondary flex-1">
                        Cancel
                    </a>
                </div>

                <!-- Info -->
                <p class="text-sm text-gray-600 text-center">
                    Your post will be reviewed by our team before appearing on the community page.
                </p>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-2xl mb-2">📸</p>
                <h3 class="font-semibold text-gray-900 mb-2">Use Descriptive Titles</h3>
                <p class="text-sm text-gray-600">Help others find your post with clear, descriptive titles that capture the essence of your experience.</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-2xl mb-2">🎯</p>
                <h3 class="font-semibold text-gray-900 mb-2">Be Detailed</h3>
                <p class="text-sm text-gray-600">Share specific details, tips, and insights that will help and inspire other members of the community.</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-2xl mb-2">✨</p>
                <h3 class="font-semibold text-gray-900 mb-2">Stay Authentic</h3>
                <p class="text-sm text-gray-600">Share your genuine experiences and perspectives. Authenticity builds community trust and engagement.</p>
            </div>
        </div>
    </div>
</div>
@endsection

