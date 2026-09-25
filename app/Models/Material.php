<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'youtube_link',
        'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_link) {
            return null;
        }

        if (str_contains($this->youtube_link, 'youtu.be/')) {
            $id = basename(parse_url($this->youtube_link, PHP_URL_PATH));
        } else {
            parse_str(parse_url($this->youtube_link, PHP_URL_QUERY) ?? '', $query);
            $id = $query['v'] ?? null;
        }

        return $id ? 'https://www.youtube.com/embed/' . $id : null;
    }
}