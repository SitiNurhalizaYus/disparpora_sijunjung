<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserLevel;
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

    protected $fillable = [
        'role_id',
        'nik',
        'name',
        'gender',
        'reg_date',
        'email',
        'last_login',
        'email_verified_at',
        'password',
        'address',
        'phone_number',
        'photo',
        'is_active'
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function role()
    {
        return $this->belongsTo(UserLevel::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'admin_id');
    }

    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class, 'pengguna_id');
    }
}
