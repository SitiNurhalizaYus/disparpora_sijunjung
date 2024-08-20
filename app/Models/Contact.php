<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'subject', 'message', 'is_active','created_by','updated_by'];

    // Relasi ke pengguna yang membuat agenda
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
