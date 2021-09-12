<?php

namespace Database\Seeders;

use App\Models\Depense;
use DateTime;
use Illuminate\Database\Seeder;

class DepenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $depenses = [
            [
                'nom_dep' => 'Règlement de location',
                'montant_dep' => 100000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'le règlement de location',
            ],
            [
                'nom_dep' => 'Ration alimentaire',
                'montant_dep' => 50000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'L’achat de ration alimentaire',
            ],
            [
                'nom_dep' => 'Paiement de l’école des enfants',
                'montant_dep' => 100000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'le paiement de l’école des enfants',
            ],
            [
                'nom_dep' => 'Facture du wifi',
                'montant_dep' => 12000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'le règlement de la facture du wifi',
            ],
            [
                'nom_dep' => 'Transport des ordures ménagères',
                'montant_dep' => 12000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'le paiement pour le transport des ordures ménagères',
            ],
            [
                'nom_dep' => 'L’abonnement télé',
                'montant_dep' => 10000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 1,
                'description_dep' => 'le paiement de l’abonnement télé',
            ],
            [
                'nom_dep' => 'Règlement de facture d’électricité',
                'montant_dep' => 20000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 2,
                'description_dep' => 'le règlement de facture d’électricité',
            ],
            [
                'nom_dep' => 'Règlement de facture d’eau',
                'montant_dep' => 10000,
                'categorie_dep_id' => 1,
                'sous_categorie_dep_id' => 2,
                'description_dep' => 'le règlement de facture d’électricité',
            ],
            [
                'nom_dep' => 'l’achat de fruit',
                'montant_dep' => 5000,
                'categorie_dep_id' => 2,
                'sous_categorie_dep_id' => null,
                'description_dep' => 'l’achat de fruit',
            ],
            [
                'nom_dep' => 'l’achat de carburant',
                'montant_dep' => 7000,
                'categorie_dep_id' => 2,
                'sous_categorie_dep_id' => null,
                'description_dep' => 'l’achat , de carburant',
            ],
        ];

        for ($i=0; $i < 4; $i++) {
            for ($j=0; $j < 10; $j++) {
                $randomTimestamp = mt_rand(strtotime('2021-09-01 00:00:00'), strtotime('2021-09-14 00:00:00'));
                $randomDate = new DateTime();
                $randomDate->setTimestamp($randomTimestamp);

                Depense::create([
                    'nom_dep' => $depenses[$j]['nom_dep'],
                    'montant_dep' => $depenses[$j]['montant_dep'],
                    'categorie_dep_id' => $depenses[$j]['categorie_dep_id'],
                    'sous_categorie_dep_id' => $depenses[$j]['sous_categorie_dep_id'],
                    'description_dep' => $depenses[$j]['description_dep'],
                    'user_id' => $i + 1,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);
            }
        }
    }
}
