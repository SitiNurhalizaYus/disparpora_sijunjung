<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Pricing extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
        'id',
        'name',
        'price',
        'description_short',
        'description_long',
        'notes',
        'is_active'
    ];
}
