<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Konten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagKonten extends Model
{
    use HasFactory;

    protected $fillable = [
        'konten_id',
        'tag_id',
        'is_active'
    ];

    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
