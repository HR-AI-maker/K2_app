<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display a listing of published community posts.
     */
    public function index(Request $request)
    {
        $query = CommunityPost::where('status', 'published')->orWhere('status', 'approved');

        // Search by title, content, region
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by post type
        if ($postType = $request->input('post_type')) {
            $query->where('post_type', $postType);
        }

        // Filter by region
        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $posts = $query->with('user', 'approvedBy')->paginate(12);

        // Get distinct regions for filter
        $regions = CommunityPost::where('status', 'published')
            ->orWhere('status', 'approved')
            ->distinct()
            ->pluck('region')
            ->sort()
            ->values();

        return view('community.index', [
            'posts' => $posts,
            'regions' => $regions,
            'currentPostType' => $request->input('post_type'),
            'currentRegion' => $request->input('region'),
            'currentSearch' => $request->input('search'),
        ]);
    }

    /**
     * Display the specified community post.
     */
    public function show(CommunityPost $post)
    {
        // Only show published or approved posts to public
        if ($post->status !== 'published' && $post->status !== 'approved') {
            // Allow users to view their own draft posts
            if (auth()->check() && $post->user_id === auth()->id()) {
                // Show with draft banner
            } else {
                abort(404);
            }
        }

        $post->load('user', 'approvedBy');

        return view('community.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for creating a new community post.
     */
    public function create()
    {
        return view('community.create');
    }

    /**
     * Store a newly created community post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string', 'min:10'],
            'post_type' => ['required', 'in:post,journal,photo'],
            'region' => ['required', 'string', 'max:100'],
        ]);

        try {
            $post = CommunityPost::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'content' => $validated['content'],
                'post_type' => $validated['post_type'],
                'region' => $validated['region'],
                'status' => 'draft', // Draft until admin approval
            ]);

            return redirect()
                ->route('community.show', $post)
                ->with('success', 'Post created! It will be visible once approved by our team.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create post. Please try again.');
        }
    }
}
