<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipHistory extends Model
{
    use HasFactory;

    protected $table = 'membership_history';

    protected $fillable = [
        'user_id',
        'membership_tier',
        'status', // active, expired, suspended, renewal_pending
        'started_at',
        'expires_at',
        'renewal_reminder_sent_at',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'renewal_reminder_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }
}
