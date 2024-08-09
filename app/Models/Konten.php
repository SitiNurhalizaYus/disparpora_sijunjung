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

   /**
     * Relasi ke model Kategori
     * 
     * Setiap Konten dimiliki oleh satu Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke model Label
     * 
     * Setiap Konten dapat memiliki banyak Label
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_kontens', 'konten_id', 'label_id');
    }

    /**
     * Relasi ke model Comment
     * 
     * Setiap Konten dapat memiliki banyak Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Mengambil tahun dari kolom created_at
     */
    public function getYearAttribute()
    {
        return $this->created_at->format('Y');
    }

}
