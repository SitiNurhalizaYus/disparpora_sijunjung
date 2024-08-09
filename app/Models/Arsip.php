<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'bulan',
        'label_slug',
    ];

    // Relasi dengan model Label
    public function label()
    {
        return $this->belongsTo(Label::class, 'label_slug', 'slug');
    }
}
