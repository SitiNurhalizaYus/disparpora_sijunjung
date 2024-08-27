<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Mitra extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = ['name', 'image', 'link', 'notes', 'is_active'];
}
