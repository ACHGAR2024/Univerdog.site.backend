<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date_appointment');  // Date du rendez-vous
            $table->time('time_appointment');  // Heure du rendez-vous
            $table->string('status');  // Statut du rendez-vous (par exemple, "Confirmé", "Annulé")
            $table->foreignId('dog_id')->constrained('dogs')->onDelete('cascade');  // Clé étrangère vers la table dogs
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Clé étrangère vers la table professionals
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}