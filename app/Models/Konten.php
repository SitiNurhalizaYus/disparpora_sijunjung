<?php

namespace App\Models;

use App\Models\Tag;
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

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi many-to-many dengan model Tag melalui tabel pivot tag_kontens
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_kontens', 'konten_id', 'tag_id');
    }

    // Relasi one-to-many dengan model Comment
    public function comments()
    {
        return $this->hasMany(Comment::class, 'konten_id');
    }

}
