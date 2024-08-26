<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Event;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use BlameableTrait;
    protected $table = 'users'; // Nama tabel

    protected $primaryKey = 'id_user';
    protected $fillable = [
        'level_id',
        'username',
        'password',
        'name',
        'email',
        'picture',
        'notes',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Method untuk JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Ini akan menggunakan primary key 'id_user'
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    
    // Relasi ke Konten yang dibuat oleh user
    public function createdContents()
    {
        return $this->hasMany(Content::class, 'created_by');
    }

    // Relasi ke Konten yang diperbarui oleh user
    public function updatedContents()
    {
        return $this->hasMany(Content::class, 'updated_by');
    }

    // Relasi ke pengaturan yang dibuat pengguna
    public function settings()
    {
        return $this->hasMany(Setting::class, 'created_by');
    }

    // Relasi ke sliders yang dibuat pengguna
    public function sliders()
    {
        return $this->hasMany(Slider::class, 'created_by');
    }

    // Relasi ke galeri yang dibuat pengguna
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'created_by');
    }

    // Relasi ke agendas yang dibuat pengguna
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'created_by');
    }

    // Relasi ke announcements yang dibuat pengguna
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    // Relasi ke partners yang dibuat pengguna
    public function partners()
    {
        return $this->hasMany(Partner::class, 'created_by');
    }

    // public function userLevel() {
    //     return $this->belongsTo(UserLevel::class, 'level_id', 'id_level');
    // }
    
}
