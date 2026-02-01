<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nettoyages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_nettoyage_id')->constrained('taches_nettoyage')->restrictOnDelete();

            $table->dateTime('done_at');

            $table->text('commentaire')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->timestamps();

            $table->index(['tache_nettoyage_id', 'done_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('nettoyages');
    }
};
