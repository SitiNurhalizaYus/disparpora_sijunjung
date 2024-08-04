<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konten extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'description_short',
        'description_long',
        'gambar',
        'is_active',
        'created_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_kontens');
    }
}
