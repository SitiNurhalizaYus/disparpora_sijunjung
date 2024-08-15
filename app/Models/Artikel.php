<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Arsip;
use App\Models\Label;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'kontens';

    // Kolom yang bisa diisi secara massal  
    protected $fillable = [
        'judul',
        'slug',
        'description_short',
        'description_long',
        'kategori_id',
        'gambar',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class);
    }
 
}
