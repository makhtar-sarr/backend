<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prenom',
        'nom',
        'poste',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function depensesUser()
    {
        return $this->hasMany(Depense::class);
    }

    public function revenusUser()
    {
        return $this->hasMany(Revenu::class);
    }

    public function categorieDepsUser()
    {
        return $this->hasMany(CategorieDep::class);
    }

    public function sousCategorieDepsUser()
    {
        return $this->hasMany(SousCategorieDep::class);
    }

    public function categorieRevsUser()
    {
        return $this->hasMany(CategorieRev::class);
    }
}
