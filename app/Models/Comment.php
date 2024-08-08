<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'konten_id',
        'user_id',
        'content',
        'is_active'
    ];

    /**
     * Get the konten that owns the comment.
     */
    public function konten()
    {
        return $this->belongsTo(Konten::class, 'konten_id');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
