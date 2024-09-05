<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('appointments')->insert([
            [
                'date_appointment' => '2024-09-25',
                'time_appointment' => '10:00:00',
                'status' => 'Confirmé',
                'dog_id' => 1,  // Assurez-vous que le chien avec cet ID existe
                'professional_id' => 1,  // Assurez-vous que le professionnel avec cet ID existe
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_appointment' => '2024-09-26',
                'time_appointment' => '14:30:00',
                'status' => 'En attente',
                'dog_id' => 2,  // Assurez-vous que le chien avec cet ID existe
                'professional_id' => 1,  // Assurez-vous que le professionnel avec cet ID existe
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_appointment' => '2024-09-27',
                'time_appointment' => '09:15:00',
                'status' => 'Annulé',
                'dog_id' => 3,  // Assurez-vous que le chien avec cet ID existe
                'professional_id' => 2,  // Assurez-vous que le professionnel avec cet ID existe
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}