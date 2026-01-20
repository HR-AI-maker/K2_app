<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MembershipService;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    /**
     * Display list of all members with filtering.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by membership status
        if ($status = $request->input('status')) {
            $query->where('membership_status', $status);
        }

        // Filter by membership tier
        if ($tier = $request->input('tier')) {
            $query->where('membership_tier', $tier);
        }

        // Filter by user type
        if ($type = $request->input('type')) {
            $query->where('user_type', $type);
        }

        // Filter by climbing discipline
        if ($discipline = $request->input('discipline')) {
            $query->where('climbing_discipline', $discipline);
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $members = $query->paginate(15);

        // Get stats
        $stats = [
            'total' => User::count(),
            'active' => User::where('membership_status', 'active')->count(),
            'expired' => User::where('membership_status', 'expired')->count(),
            'suspended' => User::where('membership_status', 'suspended')->count(),
            'pending' => User::where('membership_verified_at', null)->count(),
        ];

        return view('admin.members.index', [
            'members' => $members,
            'stats' => $stats,
        ]);
    }

    /**
     * Display member details.
     */
    public function show(User $user)
    {
        $user->load(['documents', 'medicalInfo', 'membershipHistory', 'eventRegistrations', 'expeditionApplications']);

        return view('admin.members.show', ['member' => $user]);
    }

    /**
     * Show the edit form for member.
     */
    public function edit(User $user)
    {
        return view('admin.members.edit', ['member' => $user]);
    }

    /**
     * Update member information.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string',
            'climbing_discipline' => 'required|in:trekking,rock,ice,mountaineering',
            'user_type' => 'required|in:local,foreign',
            'membership_tier' => 'required|in:pending,standard,premium,lifetime',
            'membership_status' => 'required|in:active,expired,suspended',
        ]);

        $user->update($validated);

        return redirect()->route('admin.members.show', $user)->with('success', 'Member updated successfully!');
    }

    /**
     * Verify a member's account.
     */
    public function verify(User $user)
    {
        $tier = request()->input('tier', 'standard');

        $this->membershipService->verifyMembership($user->id, $tier);

        return redirect()->route('admin.members.show', $user)->with('success', 'Member verified successfully!');
    }

    /**
     * Suspend a member's account.
     */
    public function suspend(User $user)
    {
        $this->membershipService->suspendMembership($user->id);

        return redirect()->route('admin.members.show', $user)->with('success', 'Member suspended successfully!');
    }

    /**
     * Reactivate a member's account.
     */
    public function reactivate(User $user)
    {
        $this->membershipService->renewMembership($user->id);

        return redirect()->route('admin.members.show', $user)->with('success', 'Member reactivated successfully!');
    }

    /**
     * Delete a member account.
     */
    public function destroy(User $user)
    {
        $name = $user->full_name;
        $user->forceDelete();

        return redirect()->route('admin.members.index')->with('success', "Member {$name} deleted successfully!");
    }

    /**
     * Get member statistics.
     */
    public function stats()
    {
        return [
            'total' => User::count(),
            'active' => User::where('membership_status', 'active')->count(),
            'pending' => User::where('membership_verified_at', null)->count(),
            'expired' => User::where('membership_status', 'expired')->count(),
            'suspended' => User::where('membership_status', 'suspended')->count(),
        ];
    }
}
