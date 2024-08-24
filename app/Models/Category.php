<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Nama tabel

    protected $fillable = ['name', 'slug', 'is_active'];

    // Relasi dengan model Content
    public function contents()
    {
        return $this->hasMany(Content::class, 'category_id');
    }
}
