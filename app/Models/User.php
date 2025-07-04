<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    public function isPemilik()
    {
        return $this->role === 'pemilik';
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    const USER_ROLES = [
        'Kasir' => 'Kasir',
        'Pemilik' => 'Pemilik',
    ];
}
