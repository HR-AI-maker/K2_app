<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }

    /**
     * Display member dashboard
     */
    public function index(): View
    {
        $user = auth()->user();

        // Get statistics
        $stats = [
            'active_membership' => $user->membership_status === 'active',
            'membership_tier' => $user->membership_tier,
            'membership_expires_at' => $user->membership_expires_at ?? now()->addYear(),
            'total_orders' => $user->orders()->count() ?? 0,
            'total_cart_items' => $user->cartItems()->sum('quantity') ?? 0,
        ];

        return view('member.dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }
}
