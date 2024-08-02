<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLevel extends Model
{
    use HasFactory;
    use BlameableTrait;
    protected $fillable = [
        'role',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
