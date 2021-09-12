<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'prenom' => 'Mamadou',
                'nom' => 'Ndaye',
                'poste' => 'Conducteur',
                'email' => 'mamadou.ndiaye@gmail.com',
                'password' => 'passer123',
            ],
            [
                'prenom' => 'Fatou',
                'nom' => 'Diop',
                'poste' => 'Enseignante',
                'email' => 'fatou.diop@gmail.com',
                'password' => 'passer123',
            ],
            [
                'prenom' => 'Ibrahima',
                'nom' => 'Fall',
                'poste' => 'Banquier',
                'email' => 'ibrahima.fall@gmail.com',
                'password' => 'passer123',
            ],
            [
                'prenom' => 'Aminata',
                'nom' => 'Diouf',
                'poste' => 'Agent immobiliere',
                'email' => 'aminata.diouf@gmail.com',
                'password' => 'passer123',
            ],
        ];

        for ($i=0; $i < 4 ; $i++) {
            User::create([
                'prenom' => $users[$i]['prenom'],
                'nom' => $users[$i]['nom'],
                'poste'  => $users[$i]['poste'],
                'email' => $users[$i]['email'],
                'password' => bcrypt($users[$i]['password']),
            ]);
        }

    }
}
