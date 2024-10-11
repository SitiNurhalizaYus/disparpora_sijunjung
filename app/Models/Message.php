<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
    'name', 'email', 'subject', 'message', 'file_path', 'created_by', 'updated_by','is_active'
    ];

    protected $casts = [
        'verified' => 'boolean',
    ];

     // Relasi ke pengguna yang membuat agenda
     public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
