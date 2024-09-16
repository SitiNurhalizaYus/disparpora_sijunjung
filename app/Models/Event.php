<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'organizer', // Tambahkan penyelenggara di sini
        'event_date',
        'description',
        'image',
        'event_link',
        'is_active'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan model User sebagai updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
