<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        return true; // Public can view limited user data
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->isAdmin();
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user): bool
    {
        return true; // Anyone can register
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can verify membership.
     */
    public function verifyMembership(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view sensitive info.
     */
    public function viewSensitiveInfo(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->isAdmin();
    }
}
