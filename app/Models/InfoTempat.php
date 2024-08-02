<?php

namespace App\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoTempat extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'nama',
        'deskripsi',
        'fasilitas',
        'jam_operasional',
        'harga_tiket', //as string
        'tipe_tempat',
        'is_active'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    // Mutator untuk mengonversi harga_tiket menjadi string
    public function setHargaTiketAttribute($value)
    {
        $this->attributes['harga_tiket'] = $value ? (string)$value : null;
    }
}
