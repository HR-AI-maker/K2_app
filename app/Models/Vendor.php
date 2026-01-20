<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'business_type', // guide, transport, lodging, equipment, other
        'description',
        'is_certified',
        'certification_details',
        'status', // pending, verified, suspended
        'verified_by',
        'verified_at',
        'rating',
        'total_bookings',
    ];

    protected $casts = [
        'is_certified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function services()
    {
        return $this->hasMany(VendorService::class);
    }
}
