<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReviewImage extends Model
{
    protected $fillable = [
        'review_id',
        'image_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
