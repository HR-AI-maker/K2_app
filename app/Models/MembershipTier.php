<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'features',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function membershipTransactions(): HasMany
    {
        return $this->hasMany(MembershipTransaction::class);
    }

    public function getFeatures(): array
    {
        return is_array($this->features) ? $this->features : [];
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->getFeatures());
    }
}
