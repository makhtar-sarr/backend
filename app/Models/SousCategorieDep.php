<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorieDep extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_sous_cat',
        'categorie_dep_id',
        'desc_sous_cat',
        'user_id',
    ];

    public function categorieDep()
    {
        return $this->belongsTo(CategorieDep::class);
    }

    public function depensesSousCat()
    {
        return $this->hasMany(Depense::class);
    }

    public function userSousCat()
    {
        return $this->belongsTo(User::class);
    }
}
