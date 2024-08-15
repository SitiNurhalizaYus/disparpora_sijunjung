<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Slider extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = ['name', 'description', 'image', 'link', 'notes', 'is_active', 'created_by'];

    // Relasi ke pengguna yang membuat slider
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
