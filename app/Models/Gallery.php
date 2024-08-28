<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'type', 'file_path', 'is_active', 'created_by','updated_by'];

    // Definisi atribut enum untuk galeri
    const TYPE_GAMBAR = 'gambar';
    const TYPE_VIDEO = 'video';

    // Relasi ke pengguna yang membuat galeri
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
