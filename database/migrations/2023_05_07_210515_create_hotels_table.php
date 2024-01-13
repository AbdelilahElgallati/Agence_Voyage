<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('nom_hotel');
            $table->string('pays_hotel');
            $table->string('ville_hotel');
            $table->string('adresse_hotel');
            $table->string('num_tel_hotel');
            $table->text('image_hotel');
            $table->text('contrat_hotel');
            $table->string('type_hotel');
            $table->integer('nbr_etoil_hotel');
            $table->float('prix_hotel');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
