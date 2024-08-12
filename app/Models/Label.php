<?php

namespace App\Models;

use App\Models\Konten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'kategori_id',
        'is_active'
    ];
    
    // Relasi many-to-one dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi one-to-many dengan Konten
    public function kontens()
    {
        return $this->hasMany(Konten::class, 'label_id');
    }
}
