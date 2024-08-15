<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Arsip;
use App\Models\Label;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konten extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'kontens';

    // Kolom yang bisa diisi secara massal  
    protected $fillable = [
        'id',
        'title',
        'slug',
        'description_short',
        'description_long',
        'type', // profil, berita, artikel
        'kategori_id',
        'photo',
        'is_active',
        'created_by',
        'updated_by',
        'created_at'
    ];

    // Relasi dengan model Category
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi dengan model Arsip
    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
 
}
