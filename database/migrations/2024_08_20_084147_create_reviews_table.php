<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');  // Note de la revue 
            $table->text('comment')->nullable();  // Commentaire de la revue
            $table->date('date_review');  // Date de la revue
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Clé étrangère vers la table professionals
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}