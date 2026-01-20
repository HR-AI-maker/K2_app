<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Determine if the user can access admin panel.
     */
    public function accessAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage users.
     */
    public function manageUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage events.
     */
    public function manageEvents(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage memberships.
     */
    public function manageMemberships(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view audit logs.
     */
    public function viewAuditLogs(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage vendors.
     */
    public function manageVendors(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage safety records.
     */
    public function manageSafety(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view system reports.
     */
    public function viewReports(User $user): bool
    {
        return $user->isAdmin();
    }
}
