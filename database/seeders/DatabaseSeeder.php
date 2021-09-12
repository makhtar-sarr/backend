<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // $this->call(CategorieDepSeeder::class);
        // $this->call(SousCategorieDepSeeder::class);
        $this->call(DepenseSeeder::class);
        // $this->call(CategorieRevSeeder::class);
        $this->call(RevenuSeeder::class);
    }
}
