<?php

namespace App\Models;

use App\Models\Event;
use App\Models\InfoTempat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'address', 
        'phone', 
        'email', 
        'website', 
        'is_active'
    ];

    public function infoTempats()
    {
        return $this->hasMany(InfoTempat::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
