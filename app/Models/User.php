<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'matricule',
        'fonction',
        'solde_conges',
    ];
    public function conges()
{
    return $this->hasMany(Conge::class);
}

public function missions()
{
    return $this->hasMany(Mission::class);
}


    protected $hidden = [
        'password',
        'remember_token',
    ];
}
