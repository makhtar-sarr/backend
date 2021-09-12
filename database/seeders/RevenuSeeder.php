<?php

namespace Database\Seeders;

use App\Models\Revenu;
use DateTime;
use Illuminate\Database\Seeder;

class RevenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $revenu =[
            [
                'montant_rev' => 500000,
                'categorie_rev_id' => 1,
            ],
            // [
            //     'montant_rev' => 500000,
            //     'categorie_rev_id' => 2,
            // ],
            // [
            //     'montant_rev' => 100000,
            //     'categorie_rev_id' => 2,
            // ],
            // [
            //     'montant_rev' => 500000,
            //     'categorie_rev_id' => 1,
            // ]
        ];

        for ($i=0; $i < 4; $i++) {
            for ($j=0; $j < 1; $j++) {
                $randomTimestamp = mt_rand(strtotime('2021-09-01 16:00:00'), strtotime('2021-09-05 18:00:00'));
                $randomDate = new DateTime();
                $randomDate->setTimestamp($randomTimestamp);

                Revenu::create([
                    'montant_rev' => $revenu[$j]['montant_rev'],
                    'categorie_rev_id' => $revenu[$j]['categorie_rev_id'],
                    'user_id' => $i + 1,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);
            }
        }
    }
}
