<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id(); // Utilise bigIncrements par défaut
            $table->unsignedBigInteger('place_id'); // Assurez-vous que c'est bigInteger
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->string('photo_path');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}