<?php

namespace App\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoTempat extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'name',
        'description',
        'facilities',
        'operating_hours',
        'ticket_price',
        'images',
        'link',
        'is_active'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

}
