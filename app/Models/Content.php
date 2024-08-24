<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $table = 'contents'; // Nama tabel
    protected $primaryKey = 'id_content';
    protected $fillable = [
        'title', 'slug', 'content', 'description_short', 'image', 'type', 'category_id', 'arsip_id', 'is_active', 'created_by','updated_by'
    ];

    // Definisi atribut enum untuk konten
    const TYPE_PROFIL = 'profil';
    const TYPE_BERITA = 'berita';
    const TYPE_ARTIKEL = 'artikel';

    // Relasi dengan model Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi dengan model Arsip
    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }

    // Relasi dengan model User sebagai created_by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan model User sebagai updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
