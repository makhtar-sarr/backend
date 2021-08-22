<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_rev',
        'categorie_rev_id',
        'user_id',
    ];

    public function categorieRev()
    {
        return $this->belongsTo(CategorieRev::class);
    }

    public function userRev()
    {
        return $this->belongsTo(User::class);
    }
}
