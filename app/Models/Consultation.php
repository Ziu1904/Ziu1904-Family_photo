<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'class_name',
        'phone',
        'area',
        'student_count',
        'time',
        'note',
        'status',
        'manager_response',
    ];

    protected $casts = [
        'student_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
