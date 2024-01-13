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
        Schema::create('voyages', function (Blueprint $table) {
            $table->id();
            $table->string('pays_voyage');
            $table->string('ville_voyage');
            $table->date('date_debut_voyage');
            $table->date('date_fin_voyage');
            $table->integer('nbr_personne_voyage');
            $table->integer('nbr_place_reste_voyage')->nullable();
            $table->string('numero_tel_voyage');
            $table->string('type_hibergement');
            $table->string('image_voyage');
            $table->float('prix_voyage');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyages');
    }
};
