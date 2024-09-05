<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsPhotosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dogs_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->constrained('dogs')->onDelete('cascade');  // Clé étrangère vers la table dogs
            $table->string('photo_name_dog');  // Nom du fichier photo
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dogs_photos');
    }
}