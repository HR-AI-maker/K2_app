<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display a list of community posts for moderation.
     */
    public function index(Request $request)
    {
        $query = CommunityPost::query();

        // Filter by status
        $status = $request->input('status', 'draft');
        if ($status === 'draft') {
            $query->where('status', 'draft');
        } elseif ($status === 'published') {
            $query->where('status', 'published')
                  ->orWhere('status', 'approved');
        } elseif ($status === 'hidden') {
            $query->where('status', 'hidden');
        } elseif ($status === 'all') {
            // No filter - show all
        } else {
            $query->where('status', $status);
        }

        // Filter by post type
        if ($postType = $request->input('post_type')) {
            $query->where('post_type', $postType);
        }

        // Search by title, content, region, or user
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Load user relationships
        $posts = $query->with('user', 'approvedBy')
                      ->paginate(15);

        // Calculate statistics
        $stats = [
            'draft' => CommunityPost::where('status', 'draft')->count(),
            'published' => CommunityPost::where('status', 'published')
                                       ->orWhere('status', 'approved')
                                       ->count(),
            'hidden' => CommunityPost::where('status', 'hidden')->count(),
            'total' => CommunityPost::count(),
        ];

        $currentStatus = $request->input('status', 'draft');

        return view('admin.community.index', [
            'posts' => $posts,
            'stats' => $stats,
            'currentStatus' => $currentStatus,
            'currentPostType' => $request->input('post_type'),
        ]);
    }

    /**
     * Approve a draft post for publishing.
     */
    public function approve(Request $request, CommunityPost $post)
    {
        if ($post->status !== 'draft') {
            return back()->with('error', 'Only draft posts can be approved.');
        }

        try {
            $post->update([
                'status' => 'published',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            return redirect()
                ->route('admin.community.index')
                ->with('success', "Post '{$post->title}' approved and published.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve post. Please try again.');
        }
    }

    /**
     * Hide a post (inappropriate content).
     */
    public function hide(Request $request, CommunityPost $post)
    {
        try {
            $post->update([
                'status' => 'hidden',
            ]);

            return back()->with('success', "Post '{$post->title}' has been hidden.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to hide post. Please try again.');
        }
    }

    /**
     * Unhide a previously hidden post.
     */
    public function unhide(Request $request, CommunityPost $post)
    {
        if ($post->status !== 'hidden') {
            return back()->with('error', 'Only hidden posts can be unhidden.');
        }

        try {
            $post->update([
                'status' => 'published',
            ]);

            return back()->with('success', "Post '{$post->title}' has been unhidden.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to unhide post. Please try again.');
        }
    }

    /**
     * Delete a community post.
     */
    public function destroy(Request $request, CommunityPost $post)
    {
        try {
            $postTitle = $post->title;
            $post->delete();

            return redirect()
                ->route('admin.community.index')
                ->with('success', "Post '{$postTitle}' has been deleted.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete post. Please try again.');
        }
    }
}
