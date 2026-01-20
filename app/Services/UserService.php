<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService
{
    protected function getModel(): Model
    {
        return new User();
    }

    /**
     * Create a new user with documents.
     */
    public function createUser(array $data, array $documents = [])
    {
        $user = $this->model->create($data);

        if (!empty($documents)) {
            foreach ($documents as $document) {
                $user->documents()->create($document);
            }
        }

        return $user;
    }

    /**
     * Get user by email.
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Get all members.
     */
    public function getMembers()
    {
        return $this->model
            ->where('membership_status', 'active')
            ->get();
    }

    /**
     * Get members by tier.
     */
    public function getMembersByTier($tier)
    {
        return $this->model
            ->where('membership_status', 'active')
            ->where('membership_tier', $tier)
            ->get();
    }

    /**
     * Get users by region (for future location-based queries).
     */
    public function getUsersByType($type)
    {
        return $this->model
            ->where('user_type', $type)
            ->get();
    }

    /**
     * Update user profile.
     */
    public function updateProfile($userId, array $data)
    {
        $user = $this->findOrFail($userId);

        // Only allow certain fields to be updated from profile
        $allowedFields = [
            'first_name',
            'last_name',
            'phone',
            'address',
            'climbing_discipline',
            'profile_picture_path',
        ];

        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        $user->update($filteredData);

        return $user;
    }

    /**
     * Get user with all relationships.
     */
    public function getUserFull($userId)
    {
        return $this->findOrFail($userId)
            ->load([
                'documents',
                'medicalInfo',
                'membershipHistory',
                'eventRegistrations',
                'expeditionApplications',
                'communityPosts',
                'badges',
            ]);
    }

    /**
     * Mark user as admin.
     */
    public function makeAdmin($userId)
    {
        $user = $this->findOrFail($userId);
        $user->update(['is_admin' => true]);

        return $user;
    }

    /**
     * Revoke admin status.
     */
    public function revokeAdmin($userId)
    {
        $user = $this->findOrFail($userId);
        $user->update(['is_admin' => false]);

        return $user;
    }
}
