<?php

namespace App\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoTempat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'facilities',
        'operating_hours',
        'ticket_price',
        'image',
        'link',
        'is_active'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
