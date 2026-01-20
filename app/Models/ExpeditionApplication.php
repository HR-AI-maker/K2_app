<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpeditionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'expedition_id',
        'user_id',
        'status', // pending, approved, rejected, cancelled
        'application_notes',
        'experience_level',
        'documents_verified_at',
        'permit_uploaded_at',
        'approved_by',
        'approval_notes',
        'approved_at',
        'rejected_reason',
        'rejected_at',
    ];

    protected $casts = [
        'documents_verified_at' => 'datetime',
        'permit_uploaded_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function expedition()
    {
        return $this->belongsTo(Expedition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
