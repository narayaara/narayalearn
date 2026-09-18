<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'material_id',
        'reply_to_id',          
        'is_admin_comment',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Relasi ke komentar yang dibalas
    public function replyTo()
    {
        return $this->belongsTo(Comment::class, 'reply_to_id');
    }

    // Relasi ke balasan (replies)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_to_id')->latest();
    }
}