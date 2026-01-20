<?php

namespace App\Services;

use App\Models\User;
use App\Models\MembershipHistory;
use Illuminate\Database\Eloquent\Model;

class MembershipService extends BaseService
{
    protected function getModel(): Model
    {
        return new User();
    }

    /**
     * Verify a user's membership.
     */
    public function verifyMembership($userId, $tier = 'standard')
    {
        $user = $this->findOrFail($userId);

        $user->update([
            'membership_status' => 'active',
            'membership_tier' => $tier,
            'membership_verified_at' => now(),
        ]);

        MembershipHistory::create([
            'user_id' => $userId,
            'membership_tier' => $tier,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        return $user;
    }

    /**
     * Suspend a user's membership.
     */
    public function suspendMembership($userId, $reason = null)
    {
        $user = $this->findOrFail($userId);

        $user->update([
            'membership_status' => 'suspended',
        ]);

        return $user;
    }

    /**
     * Renew a user's membership.
     */
    public function renewMembership($userId)
    {
        $user = $this->findOrFail($userId);

        $latestHistory = $user->membershipHistory()
            ->latest('expires_at')
            ->first();

        $newExpiry = $latestHistory?->expires_at ?? now();
        $newExpiry = $newExpiry->addYear();

        $user->update([
            'membership_status' => 'active',
            'membership_verified_at' => now(),
        ]);

        MembershipHistory::create([
            'user_id' => $userId,
            'membership_tier' => $user->membership_tier,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => $newExpiry,
        ]);

        return $user;
    }

    /**
     * Check if membership is expired.
     */
    public function isMembershipExpired($userId): bool
    {
        $user = $this->findOrFail($userId);

        $latestHistory = $user->membershipHistory()
            ->latest('expires_at')
            ->first();

        if (!$latestHistory) {
            return true;
        }

        return now()->isAfter($latestHistory->expires_at);
    }

    /**
     * Get members pending verification.
     */
    public function getPendingVerification()
    {
        return $this->model
            ->where('membership_status', 'pending')
            ->get();
    }
}
