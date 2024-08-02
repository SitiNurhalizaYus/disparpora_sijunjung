<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan',
        'pilihan_1',
        'pilihan_2',
        'pilihan_3',
        'pilihan_4',
        'total_pilihan_1',
        'total_pilihan_2',
        'total_pilihan_3',
        'total_pilihan_4',
        'is_active'
    ];
}
