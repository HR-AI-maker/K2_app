<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardRedirectController extends Controller
{
    /**
     * Redirect to appropriate dashboard based on user role
     */
    public function redirect(): RedirectResponse
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('home');
        }

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }

        // Default to member dashboard
        return redirect()->route('member.dashboard');
    }
}
