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
        'id',
        'name',
        'email',
        'subject',
        'message',
        'notes',
        'is_active'
    ];

     // Relasi ke pengguna yang membuat agenda
     public function createdBy()
     {
         return $this->belongsTo(User::class, 'created_by');
     }
}
