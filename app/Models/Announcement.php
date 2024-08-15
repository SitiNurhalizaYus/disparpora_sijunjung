<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'is_active', 'created_by'];

    // Relasi ke pengguna yang membuat pengumuman
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
