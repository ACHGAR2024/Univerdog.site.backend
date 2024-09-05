<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityTable extends Migration
{
    /**
     * Run the migrations. 
     */
    public function up()
    {
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->string('day');  // Jour de la disponibilité (par exemple, "Lundi" ou "Samedi")
            $table->time('start_time');  // Heure de début
            $table->time('end_time');  // Heure de fin
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Clé étrangère vers la table professionals
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('availability');
    }
}