<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'event_date', 'organizer', 'file_path', 'is_active', 'created_by'];

    // Relasi ke pengguna yang membuat agenda
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
