<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('specialty')->insert([
            [
                'name_speciality' => 'Vétérinaire',
                'professional_id' => 1,  // Assurez-vous que professional_id 1 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Toiletteur canin',
                'professional_id' => 1,  // Assurez-vous que professional_id 2 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Éducateur canin',
                'professional_id' => 1,  // Assurez-vous que professional_id 3 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Comportementaliste canin',
                'professional_id' => 1,  // Assurez-vous que professional_id 4 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Éleveur canin',
                'professional_id' => 1,  // Assurez-vous que professional_id 5 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Assistant vétérinaire',
                'professional_id' => 1,  // Assurez-vous que professional_id 6 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Pension canine',
                'professional_id' => 1,  // Assurez-vous que professional_id 7 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Dresseur de chiens de travail',
                'professional_id' => 1,  // Assurez-vous que professional_id 8 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Conseiller en nutrition canine',
                'professional_id' => 1,  // Assurez-vous que professional_id 9 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_speciality' => 'Praticien en massage canin',
                'professional_id' => 1, // Assurez-vous que professional_id 10 existe dans la table professionals
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}