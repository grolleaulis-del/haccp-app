<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lots_utilisation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->restrictOnDelete();

            $table->foreignId('arrivage_ligne_id')->nullable()
                ->constrained('arrivage_lignes')->nullOnDelete();

            $table->string('statut')->default('actif');

            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();

            $table->string('photo_path')->nullable();
            $table->string('code_interne')->nullable();

            $table->text('commentaire')->nullable();

            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->timestamps();

            $table->index(['produit_id', 'statut']);
            $table->index(['started_at', 'ended_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('lot_utilisations');
    }
};
