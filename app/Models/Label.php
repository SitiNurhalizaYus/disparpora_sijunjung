<?php

namespace App\Models;

use App\Models\Konten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];

    public function kontens()
    {
        return $this->belongsToMany(Konten::class, 'label_kontens', 'label_id', 'konten_id');
    }
}
