<?php

namespace Database\Seeders;

use App\Models\CategorieDep;
use Illuminate\Database\Seeder;

class CategorieDepSeeder extends Seeder
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
                'nom_cat' => 'Depense Fixe',
                'description_cat' => 'dépenses fixes faites une seule fois en début de mois.',
            ],
            [
                'nom_cat' => 'Dépenses spontanées',
                'description_cat' => 'Dépenses spontanées qu’on ne peut prévoir.',
            ],
        ];

        for ($i=0; $i < 2 ; $i++) {
            CategorieDep::create([
                'nom_cat' => $categorie[$i]['nom_cat'],
                'description_cat' => $categorie[$i]['description_cat'],
                'user_id' => 1,
            ]);
        }
    }
}
