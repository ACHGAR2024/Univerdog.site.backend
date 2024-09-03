<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    use CanResetPasswordTrait;
    
    protected $fillable = [
        'name', 'image', 'email', 'email_verified_at', 'password', 'role', 'google_id', 'avatar', 'first_name', 'address', 'postal_code', 'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function places()
    {
        return $this->hasMany(Place::class);
    }
    
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}