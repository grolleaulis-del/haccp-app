<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arrivage_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arrivage_id')->constrained('arrivages')->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained('produits')->restrictOnDelete();

            $table->string('numero_lot')->nullable();
            $table->string('photo_path')->nullable();

            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->index(['arrivage_id', 'produit_id']);
            $table->index('numero_lot');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('arrivage_lignes');
    }
};
