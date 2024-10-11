<?php

namespace App\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VirtualTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        // 'facilities',
        // 'operating_hours',
        // 'ticket_price',
        'image',
        'link',
        'is_active',
        'note',
        'created_by',
        'updated_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan model User sebagai updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
