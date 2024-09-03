<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); 
            $table->string('image', 255)->nullable();
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('password', 255)->nullable(); // Changed to nullable() google
            $table->string('google_id'); // Added google
            $table->string('avatar')->nullable(); // Added google
            
            $table->string('first_name', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code', 8)->nullable();
            $table->string('phone', 20)->nullable();
            
            
            $table->string('role', 255)->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('role_id')->unsigned()->default(2)->comment('1: Administrateur, 2: Utilisateur, 3: Professionnel');
        });

        // Insérer un compte administrateur unique
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}