<?php

namespace App\Models;

use App\Models\Konten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'is_active'
    ];

    public function kontens()
    {
        return $this->hasMany(Konten::class);
    }
}
