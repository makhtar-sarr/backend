<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_dep',
        'montant_dep',
        'categorie_dep_id',
        'sous_categorie_dep_id',
        'description_dep',
        'user_id'
    ];

    public function categorieDep()
    {
        return $this->belongsTo(CategorieDep::class);
    }

    public function sousCategorieDep()
    {
        return $this->belongsTo(SousCategorieDep::class);
    }

    public function userDep()
    {
        return $this->belongsTo(User::class);
    }
}
