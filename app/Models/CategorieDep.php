<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieDep extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_cat',
        'description_cat',
        'user_id',
    ];

    public function depensesCat()
    {
        return $this->hasMany(Depense::class);
    }

    public function sousCategorieDeps()
    {
        return $this->hasMany(SousCategorieDep::class);
    }

    public function userCatDep()
    {
        return $this->belongsTo(User::class);
    }
}
