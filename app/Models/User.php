<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'address',
        'climbing_discipline',
        'profile_picture_path',
        'user_type', // local, foreign
        'membership_tier', // pending, standard, premium, lifetime
        'membership_status', // active, expired, suspended
        'membership_verified_at',
        'last_login_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'membership_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Determine if user is a member.
     */
    public function isMember(): bool
    {
        return $this->membership_status === 'active';
    }

    /**
     * Determine if user is verified.
     */
    public function isVerified(): bool
    {
        return $this->membership_verified_at !== null;
    }

    /**
     * Determine if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Relationships
     */

    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function medicalInfo()
    {
        return $this->hasOne(MedicalInfo::class);
    }

    public function membershipHistory()
    {
        return $this->hasMany(MembershipHistory::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function expeditionApplications()
    {
        return $this->hasMany(ExpeditionApplication::class);
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges');
    }
}
