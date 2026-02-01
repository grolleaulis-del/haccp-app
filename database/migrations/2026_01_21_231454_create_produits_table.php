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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('famille');
            $table->string('nom');
            $table->string('mode_tracabilite')->default('etiquette_photo');
            $table->unsignedSmallInteger('dlc_cuisson_defaut_jours')->nullable();
            $table->unsignedSmallInteger('dlc_congelation_defaut_jours')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            // Index
            $table->index('famille');
            $table->index('actif');
            $table->index('nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
