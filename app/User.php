<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function properties()
    {
        return $this->hasMany("App\Property");
    }

    public function renters()
    {
        return $this->hasMany("App\Renter");
    }

    public function contracts()
    {
        return $this->hasMany("App\Contract");
    }


    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
