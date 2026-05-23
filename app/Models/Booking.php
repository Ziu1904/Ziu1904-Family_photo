<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'package_id', 'school', 'class', 'students_count',
        'concept', 'booking_date', 'notes', 'status', 'deposit', 'total_price'
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Reviews and albums are now normalized through consultations and packages
}
