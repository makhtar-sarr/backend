<?php

namespace Database\Seeders;

use App\Models\CategorieRev;
use Illuminate\Database\Seeder;

class CategorieRevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorie = [
            [
                'nom_cat' => 'Salaire',
                'description_cat' => 'Le gain par mois',
            ],
            [
                'nom_cat' => 'Primes',
                'description_cat' => 'primes',
            ]
        ];

        for ($i=0; $i < 2 ; $i++) {
            CategorieRev::create([
                'nom_cat' => $categorie[$i]['nom_cat'],
                'description_cat' => $categorie[$i]['description_cat'],
                'user_id' => 1,
            ]);
        }
    }
}
