<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function managedVendor()
    {
        return $this->hasOne(Vendor::class, 'vendor_user_id');
    }

    public function isVendor(): bool
    {
        return $this->managedVendor()->exists() && $this->managedVendor->can_sell;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function membershipTransactions()
    {
        return $this->hasMany(MembershipTransaction::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class, 'id', 'id', 'role_id', 'id');
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasPermission(string $permission): bool
    {
        return DB::table('role_permissions')
            ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->where('role_permissions.role_id', DB::table('roles')->where('name', $this->role)->first()->id ?? 0)
            ->where('permissions.name', $permission)
            ->exists();
    }
}
