<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon_path',
        'criteria',
        'tier', // bronze, silver, gold, platinum
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges');
    }
}
