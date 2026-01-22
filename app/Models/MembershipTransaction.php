<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'membership_tier_id',
        'transaction_type',
        'amount',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class);
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->expires_at > now();
    }
}
