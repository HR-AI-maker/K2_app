<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_type', // championship, training, expedition, meetup
        'region',
        'location',
        'start_date',
        'end_date',
        'max_participants',
        'current_participants',
        'status', // draft, published, cancelled, completed
        'price_member',
        'price_nonmember',
        'eligibility_requirements',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'eligibility_requirements' => 'array',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function waitlist()
    {
        return $this->registrations()->where('status', 'waitlisted');
    }
}
