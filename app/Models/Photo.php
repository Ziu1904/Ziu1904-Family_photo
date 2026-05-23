<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'album_id',
        'image_path',
        'alt_text',
        'order',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
