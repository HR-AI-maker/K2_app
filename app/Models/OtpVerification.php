<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'otp_code',
        'expires_at',
        'purpose',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    public function isVerified(): bool
    {
        return $this->is_verified === true;
    }

    public function canAttempt(): bool
    {
        return !$this->isExpired() && !$this->isVerified();
    }

    public static function generate(string $email, string $phone, string $purpose = 'email_verification'): self
    {
        return self::create([
            'email' => $email,
            'phone' => $phone,
            'otp_code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => now()->addMinutes(10),
            'purpose' => $purpose,
            'is_verified' => false,
        ]);
    }
}
