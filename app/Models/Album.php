<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'package_id',
        'name',
        'description',
        'concept',
        'cover_image',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the cover image URL
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    /**
     * Get album photos URLs
     */
    public function getPhotosAttribute()
    {
        $photos = [];
        $albumFolder = storage_path('app/public/albums/album_' . $this->id);
        if (is_dir($albumFolder)) {
            $files = array_diff(scandir($albumFolder), array('.', '..'));
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $photos[] = asset('storage/albums/album_' . $this->id . '/' . $file);
                }
            }
        }
        return $photos;
    }
}