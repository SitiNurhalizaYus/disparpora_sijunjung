<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class UserLevel extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
        'id',
        'name',
        'notes',
        'is_active'
    ];
}
