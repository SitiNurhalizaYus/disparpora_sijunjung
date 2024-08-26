<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_arsip';

    protected $fillable = ['tahun', 'bulan', 'is_active'];

    // Relasi ke konten
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
