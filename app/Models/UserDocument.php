<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type', // cnic, passport, visa, insurance, medical
        'document_path',
        'document_url',
        'verified_at',
        'verified_by',
        'rejection_reason',
        'rejection_date',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'rejection_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
