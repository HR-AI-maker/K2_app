<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Encrypted;

class MedicalInfo extends Model
{
    use HasFactory;

    protected $table = 'medical_info';

    protected $fillable = [
        'user_id',
        'blood_type',
        'allergies',
        'medical_conditions',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'insurance_provider',
        'insurance_policy_number',
        'insurance_expiry',
    ];

    protected $casts = [
        'medical_conditions' => 'array',
        'allergies' => 'array',
        'insurance_expiry' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
