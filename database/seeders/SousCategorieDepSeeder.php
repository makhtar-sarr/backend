<?php

namespace Database\Seeders;

use App\Models\SousCategorieDep;
use Illuminate\Database\Seeder;

class SousCategorieDepSeeder extends Seeder
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
                'nom_sous_cat' => 'Depenses fixes à fréquence constante',
                'categorie_dep_id' => 1,
                'desc_sous_cat' => 'Ces montants sont fixes et connus d’avance.
                ',
            ],
            [
                'nom_sous_cat' => 'Depenses fixes à fréquence variable',
                'categorie_dep_id' => 1,
                'desc_sous_cat' => 'Les montants de ces depenses sont variables et on ne sait pas quand elles seront disponibles dans le mois.
                ',
            ],
        ];

        for ($i=0; $i < 2 ; $i++) {
            SousCategorieDep::create([
                'nom_sous_cat' => $categorie[$i]['nom_sous_cat'],
                'categorie_dep_id' => $categorie[$i]['categorie_dep_id'],
                'desc_sous_cat' => $categorie[$i]['desc_sous_cat'],
                'user_id' => 1,
            ]);
        }
    }
}
