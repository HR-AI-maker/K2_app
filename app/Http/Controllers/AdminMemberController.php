<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipTier;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminMemberController extends Controller
{
    /**
     * Constructor - ensure only admins can access
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Unauthorized. Only admins can access this.');
            }
            return $next($request);
        });
    }

    /**
     * Show list of all members with filtering
     */
    public function index(Request $request): View
    {
        $query = User::where('membership_tier', '!=', 'pending');

        // Filter by status
        $status = $request->input('status', 'all');
        if ($status === 'active') {
            $query->where('membership_status', 'active');
        } elseif ($status === 'expired') {
            $query->where('membership_status', 'expired');
        } elseif ($status === 'suspended') {
            $query->where('membership_status', 'suspended');
        } elseif ($status === 'pending_verification') {
            $query->whereNull('membership_verified_at');
        }

        // Filter by membership tier
        if ($tier = $request->input('membership_tier')) {
            $query->where('membership_tier', $tier);
        }

        // Search by user
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Get members with pagination
        $members = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => User::where('membership_tier', '!=', 'pending')->count(),
            'active' => User::where('membership_status', 'active')->count(),
            'expired' => User::where('membership_status', 'expired')->count(),
            'suspended' => User::where('membership_status', 'suspended')->count(),
            'pending_verification' => User::whereNull('membership_verified_at')->where('membership_tier', '!=', 'pending')->count(),
        ];

        return view('admin.members.index', [
            'members' => $members,
            'stats' => $stats,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Show form to add new member
     */
    public function create(): View
    {
        $tiers = MembershipTier::where('is_active', true)->get();

        return view('admin.members.create', [
            'tiers' => $tiers,
        ]);
    }

    /**
     * Store new member (admin creates directly)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'membership_tier_id' => 'required|exists:membership_tiers,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get tier name
        $tier = MembershipTier::find($validated['membership_tier_id']);

        // Map tier name to enum value
        $tierMap = [
            'Basic' => 'standard',
            'Premium' => 'premium',
            'Elite' => 'lifetime',
        ];
        $tierEnum = $tierMap[$tier->name] ?? 'standard';

        // Create user account
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'membership_tier' => $tierEnum,
            'membership_status' => 'active',
            'phone_verified_at' => now(),
        ]);

        // Create membership transaction
        MembershipTransaction::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->id,
            'amount' => $tier->price,
            'payment_method' => 'admin_direct',
            'transaction_reference' => 'ADMIN-' . strtoupper(uniqid()),
            'status' => 'paid',
        ]);

        return redirect()->route('admin.members.show', $user->id)
            ->with('success', 'Member created successfully!');
    }

    /**
     * Show member details
     */
    public function show(User $user): View
    {
        // Load relationships
        $user->load('membershipTransactions');

        return view('admin.members.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show form to edit member
     */
    public function edit(User $user): View
    {
        $tiers = MembershipTier::where('is_active', true)->get();

        return view('admin.members.edit', [
            'user' => $user,
            'tiers' => $tiers,
        ]);
    }

    /**
     * Update member details
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'membership_status' => 'required|in:active,expired,suspended',
            'membership_tier' => 'required|in:standard,premium,lifetime',
        ]);

        $user->update($validated);

        return redirect()->route('admin.members.show', $user->id)
            ->with('success', 'Member updated successfully!');
    }

    /**
     * Delete member
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully!');
    }
}
