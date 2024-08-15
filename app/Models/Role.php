<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use BlameableTrait;
    protected $fillable = ['name', 'description', 'is_active'];

    // Relasi ke pengguna
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
