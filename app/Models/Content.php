<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'content', 'description_short', 'image', 'type', 'category_id', 'arsip_id', 'is_active', 'created_by','updated_by'
    ];

    // Definisi atribut enum untuk konten
    const TYPE_PROFIL = 'profil';
    const TYPE_BERITA = 'berita';
    const TYPE_ARTIKEL = 'artikel';

    // Relasi ke kategori
    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke arsip
    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    // Relasi ke pengguna yang membuat konten
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
