<?php

namespace App\Models;

use App\Models\Berita;
use App\Models\Artikel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type','is_active'];

    public function konten()
    {
        return $this->hasMany(Konten::class);
    }
}
