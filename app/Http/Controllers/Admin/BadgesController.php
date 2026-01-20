<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\User;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class BadgesController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Display a list of badges.
     */
    public function index(Request $request)
    {
        $query = Badge::query();

        // Filter by tier
        if ($tier = $request->input('tier')) {
            $query->where('tier', $tier);
        }

        // Search by name or description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Get badges with user count
        $badges = $query->withCount('users')->paginate(12);

        // Calculate statistics
        $stats = [
            'bronze' => Badge::where('tier', 'bronze')->count(),
            'silver' => Badge::where('tier', 'silver')->count(),
            'gold' => Badge::where('tier', 'gold')->count(),
            'platinum' => Badge::where('tier', 'platinum')->count(),
            'total' => Badge::count(),
        ];

        $currentTier = $request->input('tier');

        return view('admin.badges.index', [
            'badges' => $badges,
            'stats' => $stats,
            'currentTier' => $currentTier,
        ]);
    }

    /**
     * Show the form for creating a new badge.
     */
    public function create()
    {
        $criteriaOptions = [
            'first_profile_completion' => 'First Profile Completion',
            'first_event_registration' => 'First Event Registration',
            'veteran_member' => 'Veteran Member (1+ year)',
            'community_contributor' => 'Community Contributor (5+ posts)',
            'active_member' => 'Active Member (5+ events)',
            'verified_member' => 'Verified Member',
            'event_participator' => 'Event Participator (3+ attended)',
            'expedition_explorer' => 'Expedition Explorer (2+ applications)',
            'premium_supporter' => 'Premium Supporter',
            'safety_first' => 'Safety First (Medical info complete)',
        ];

        return view('admin.badges.create', [
            'criteriaOptions' => $criteriaOptions,
        ]);
    }

    /**
     * Store a newly created badge in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:badges'],
            'description' => ['required', 'string', 'min:10'],
            'icon_path' => ['required', 'string', 'max:200'],
            'criteria' => ['required', 'string'],
            'tier' => ['required', 'in:bronze,silver,gold,platinum'],
        ]);

        try {
            Badge::create($validated);

            return redirect()
                ->route('admin.badges.index')
                ->with('success', "Badge '{$validated['name']}' created successfully.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create badge. Please try again.');
        }
    }

    /**
     * Display the specified badge.
     */
    public function show(Badge $badge)
    {
        $badge->load('users');

        return view('admin.badges.show', [
            'badge' => $badge,
        ]);
    }

    /**
     * Show the form for editing the specified badge.
     */
    public function edit(Badge $badge)
    {
        $criteriaOptions = [
            'first_profile_completion' => 'First Profile Completion',
            'first_event_registration' => 'First Event Registration',
            'veteran_member' => 'Veteran Member (1+ year)',
            'community_contributor' => 'Community Contributor (5+ posts)',
            'active_member' => 'Active Member (5+ events)',
            'verified_member' => 'Verified Member',
            'event_participator' => 'Event Participator (3+ attended)',
            'expedition_explorer' => 'Expedition Explorer (2+ applications)',
            'premium_supporter' => 'Premium Supporter',
            'safety_first' => 'Safety First (Medical info complete)',
        ];

        return view('admin.badges.edit', [
            'badge' => $badge,
            'criteriaOptions' => $criteriaOptions,
        ]);
    }

    /**
     * Update the specified badge in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:badges,name,' . $badge->id],
            'description' => ['required', 'string', 'min:10'],
            'icon_path' => ['required', 'string', 'max:200'],
            'criteria' => ['required', 'string'],
            'tier' => ['required', 'in:bronze,silver,gold,platinum'],
        ]);

        try {
            $badge->update($validated);

            return redirect()
                ->route('admin.badges.show', $badge)
                ->with('success', "Badge '{$badge->name}' updated successfully.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update badge. Please try again.');
        }
    }

    /**
     * Delete a badge.
     */
    public function destroy(Request $request, Badge $badge)
    {
        try {
            $badgeName = $badge->name;
            $badge->delete();

            return redirect()
                ->route('admin.badges.index')
                ->with('success', "Badge '{$badgeName}' deleted successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete badge. Please try again.');
        }
    }

    /**
     * Manually award a badge to a user.
     */
    public function award(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'badge_id' => ['required', 'exists:badges,id'],
        ]);

        try {
            $user = User::find($validated['user_id']);
            $badge = Badge::find($validated['badge_id']);

            $awarded = $this->badgeService->awardBadge($user, $badge);

            if ($awarded) {
                return back()->with('success', "Badge '{$badge->name}' awarded to {$user->full_name}.");
            } else {
                return back()->with('warning', "{$user->full_name} already has the badge '{$badge->name}'.");
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to award badge. Please try again.');
        }
    }

    /**
     * Get badge statistics and earnings breakdown.
     */
    public function analytics()
    {
        $badges = Badge::withCount('users')->get();
        $totalBadgesAwarded = User::join('user_badges', 'users.id', '=', 'user_badges.user_id')
            ->count();
        $averageBadgesPerUser = User::count() > 0 ? $totalBadgesAwarded / User::count() : 0;

        return view('admin.badges.analytics', [
            'badges' => $badges,
            'totalBadgesAwarded' => $totalBadgesAwarded,
            'averageBadgesPerUser' => $averageBadgesPerUser,
        ]);
    }
}
