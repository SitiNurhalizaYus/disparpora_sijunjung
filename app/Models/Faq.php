<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Faq extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
        'id',
        'question',
        'answer',
        'notes',
        'is_active'
    ];
}
