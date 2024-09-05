<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_product');  // Nom du produit
            $table->text('description_product')->nullable();  // Description du produit
            $table->decimal('price', 10, 2);  // Prix du produit
            $table->string('affiliation_link')->nullable();  // Lien d'affiliation pour le produit
            $table->foreignId('products_category_id')->constrained('products_category')->onDelete('cascade');  // Clé étrangère vers la table products_category
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}