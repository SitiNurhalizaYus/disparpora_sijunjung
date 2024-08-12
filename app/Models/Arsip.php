<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'konten_id',
        'is_active',
    ];

    // Relasi many-to-one dengan Konten
    public function konten()
    {
        return $this->belongsTo(Konten::class, 'konten_id');
    }
}
