<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'photos_count',
        'videos_count', 'concepts_count', 'features', 'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
