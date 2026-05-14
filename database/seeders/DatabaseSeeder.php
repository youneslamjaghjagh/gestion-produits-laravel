<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Le chef d'orchestre appelle votre script d'importation CSV
        $this->call([
            DatasetSeeder::class,
        ]);
    }
}
