<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelKonten extends Model
{
    // Tabel yang digunakan oleh model ini
    protected $table = 'label_kontens';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'konten_id',
        'label_id',
    ];

    // Kolom yang tidak boleh diisi secara massal
    protected $guarded = [];

    // Jika Anda tidak menggunakan timestamp, set ke false
    public $timestamps = true;

    // Definisikan relasi dengan model Konten
    public function konten()
    {
        return $this->belongsTo(Konten::class, 'konten_id');
    }

    // Definisikan relasi dengan model Label
    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
