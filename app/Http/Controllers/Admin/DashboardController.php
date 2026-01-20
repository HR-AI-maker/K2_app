<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventRegistration;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $stats = [
            'totalMembers' => User::count(),
            'activeMembers' => User::where('membership_status', 'active')->count(),
            'pendingVerification' => User::where('membership_verified_at', null)->count(),
            'expiredMembers' => User::where('membership_status', 'expired')->count(),
            'suspendedMembers' => User::where('membership_status', 'suspended')->count(),
            'activeEvents' => Event::where('status', 'published')->count(),
            'totalRegistrations' => EventRegistration::count(),
            'revenueThisMonth' => EventRegistration::whereMonth('created_at', now()->month)
                ->sum('amount_paid'),
        ];

        // Recent activity (last 10 registrations)
        $recentRegistrations = EventRegistration::with(['user', 'event'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent members
        $recentMembers = User::where('membership_verified_at', '!=', null)
            ->latest('membership_verified_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentRegistrations' => $recentRegistrations,
            'recentMembers' => $recentMembers,
        ]);
    }
}
