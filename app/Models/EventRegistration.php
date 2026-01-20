<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status', // registered, waitlisted, cancelled, completed
        'amount_paid',
        'payment_method',
        'payment_verified_at',
        'notes',
        'registered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'payment_verified_at' => 'datetime',
        'registered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
