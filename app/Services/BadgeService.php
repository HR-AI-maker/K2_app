<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService
{
    /**
     * Award a badge to a user.
     */
    public function awardBadge(User $user, Badge $badge)
    {
        // Check if user already has this badge
        if ($user->badges()->where('badge_id', $badge->id)->exists()) {
            return false;
        }

        // Award the badge
        $user->badges()->attach($badge->id, [
            'awarded_at' => now(),
        ]);

        return true;
    }

    /**
     * Remove a badge from a user.
     */
    public function removeBadge(User $user, Badge $badge)
    {
        return $user->badges()->detach($badge->id);
    }

    /**
     * Check if user is eligible for a badge and award if so.
     */
    public function checkAndAwardBadges(User $user)
    {
        $badges = Badge::all();

        foreach ($badges as $badge) {
            if ($this->isEligible($user, $badge)) {
                $this->awardBadge($user, $badge);
            }
        }
    }

    /**
     * Check if a user is eligible for a badge.
     */
    public function isEligible(User $user, Badge $badge): bool
    {
        $criteria = $badge->criteria;

        match ($criteria) {
            'first_profile_completion' => $this->hasCompletedProfile($user),
            'first_event_registration' => $this->hasRegisteredForEvent($user),
            'veteran_member' => $this->isVeteranMember($user),
            'community_contributor' => $this->isCommunityContributor($user),
            'active_member' => $this->isActiveMember($user),
            'verified_member' => $this->isVerifiedMember($user),
            'event_participator' => $this->hasParticipatedInEvents($user),
            'expedition_explorer' => $this->hasAppliedForExpeditions($user),
            'premium_supporter' => $this->isPremiumMember($user),
            'safety_first' => $this->hasCompletedMedicalInfo($user),
            default => false,
        };

        return match ($criteria) {
            'first_profile_completion' => $this->hasCompletedProfile($user),
            'first_event_registration' => $this->hasRegisteredForEvent($user),
            'veteran_member' => $this->isVeteranMember($user),
            'community_contributor' => $this->isCommunityContributor($user),
            'active_member' => $this->isActiveMember($user),
            'verified_member' => $this->isVerifiedMember($user),
            'event_participator' => $this->hasParticipatedInEvents($user),
            'expedition_explorer' => $this->hasAppliedForExpeditions($user),
            'premium_supporter' => $this->isPremiumMember($user),
            'safety_first' => $this->hasCompletedMedicalInfo($user),
            default => false,
        };
    }

    /**
     * Check if profile is 80%+ complete.
     */
    private function hasCompletedProfile(User $user): bool
    {
        $completeness = 0;
        $total = 0;

        // Basic info (5 fields: first_name, last_name, email, phone, address)
        $total += 5;
        if ($user->first_name && $user->last_name && $user->phone && $user->address) {
            $completeness += 4;
        }

        // Medical info (4 fields)
        $total += 4;
        if ($user->medicalInfo) {
            if ($user->medicalInfo->blood_type) $completeness++;
            if ($user->medicalInfo->allergies) $completeness++;
            if ($user->medicalInfo->emergency_contact_name) $completeness++;
            if ($user->medicalInfo->emergency_contact_phone) $completeness++;
        }

        // Documents (1 field: uploaded)
        $total += 1;
        if ($user->documents()->count() > 0) {
            $completeness++;
        }

        // Membership (1 field: verified)
        $total += 1;
        if ($user->isVerified()) {
            $completeness++;
        }

        $percentage = ($completeness / $total) * 100;
        return $percentage >= 80;
    }

    /**
     * Check if user has registered for at least one event.
     */
    private function hasRegisteredForEvent(User $user): bool
    {
        return $user->eventRegistrations()->exists();
    }

    /**
     * Check if user is a veteran (member for 1+ year).
     */
    private function isVeteranMember(User $user): bool
    {
        return $user->created_at->diffInMonths(now()) >= 12;
    }

    /**
     * Check if user has made community contributions (5+ posts).
     */
    private function isCommunityContributor(User $user): bool
    {
        return $user->communityPosts()
            ->where('status', 'published')
            ->orWhere('status', 'approved')
            ->count() >= 5;
    }

    /**
     * Check if user is active (5+ events registered).
     */
    private function isActiveMember(User $user): bool
    {
        return $user->eventRegistrations()->count() >= 5;
    }

    /**
     * Check if user is verified (all docs verified).
     */
    private function isVerifiedMember(User $user): bool
    {
        return $user->isVerified();
    }

    /**
     * Check if user has participated in events (attended at least 3).
     */
    private function hasParticipatedInEvents(User $user): bool
    {
        return $user->eventRegistrations()
            ->where('status', 'attended')
            ->count() >= 3;
    }

    /**
     * Check if user has applied for expeditions (2+ applications).
     */
    private function hasAppliedForExpeditions(User $user): bool
    {
        return $user->expeditionApplications()->count() >= 2;
    }

    /**
     * Check if user has premium membership.
     */
    private function isPremiumMember(User $user): bool
    {
        return $user->membership_tier === 'premium' || $user->membership_tier === 'lifetime';
    }

    /**
     * Check if user has completed medical information.
     */
    private function hasCompletedMedicalInfo(User $user): bool
    {
        return $user->medicalInfo !== null
            && $user->medicalInfo->blood_type
            && $user->medicalInfo->emergency_contact_name;
    }

    /**
     * Get user's badges count.
     */
    public function getBadgeCount(User $user): int
    {
        return $user->badges()->count();
    }

    /**
     * Get user's badges grouped by tier.
     */
    public function getBadgesByTier(User $user): array
    {
        return $user->badges()
            ->get()
            ->groupBy('tier')
            ->toArray();
    }
}
