<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UmpanBalik extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'topik_feedback',
        'pesan_feedback',
        'is_active'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class);
    }
}
