<?php

namespace App\Models;

use App\Models\Label;
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

     // Relasi one-to-many dengan Label
     public function labels()
     {
         return $this->hasMany(Label::class, 'kategori_id');
     }
 
     // Relasi one-to-many dengan Konten
     public function kontens()
     {
         return $this->hasMany(Konten::class, 'kategori_id');
     }
}
