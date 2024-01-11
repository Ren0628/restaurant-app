<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\OwnerResetPassword;


class Owner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard ='owner';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new OwnerResetPassword($token));
    }

    public function restaurants() {
        return $this->hasMany(Restaurant::class);
    }
}
