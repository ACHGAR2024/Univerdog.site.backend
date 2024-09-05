<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name_dog');  // Nom du chien 
            $table->string('breed');  // Race du chien
            $table->date('birth_date');  // Date de naissance du chien
            $table->decimal('weight', 5, 2);  // Poids du chien
            $table->string('sex');  // Sexe du chien
            $table->text('medical_info')->nullable();  // Informations médicales sur le chien, optionnelles
            $table->string('qr_code')->nullable();  // QR code pour le chien, optionnel
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Clé étrangère vers la table users
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }
}