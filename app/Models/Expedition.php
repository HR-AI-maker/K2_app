<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'region',
        'difficulty_level', // beginner, intermediate, advanced, expert
        'start_date',
        'end_date',
        'max_participants',
        'status', // planning, open, closed, completed, cancelled
        'permit_required',
        'permit_details',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function applications()
    {
        return $this->hasMany(ExpeditionApplication::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
