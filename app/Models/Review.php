<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{

    protected $fillable = [
        'consultation_id',
        'name',
        'school',
        'class',
        'quote',
        'rating',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }
}
