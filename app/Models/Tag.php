<?php

namespace App\Models;

use App\Models\Konten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tag',
        'is_active'
    ];

    public function kontens()
    {
        return $this->belongsToMany(Konten::class, 'tag_kontens');
    }
}
