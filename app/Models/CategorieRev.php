<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieRev extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_cat',
        'description_cat',
        'user_id',
    ];

    public function revenus()
    {
        return $this->hasMany(Revenu::class);
    }

    public function userCatRev()
    {
        return $this->belongsTo(User::class);
    }
}
