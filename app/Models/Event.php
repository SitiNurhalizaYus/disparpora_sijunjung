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
        'agent_id',
        'admin_id',
        'nama_acara',
        'tanggal_acara',
        'deskripsi',
        'gambar',
        'link_event',
        'is_active'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
