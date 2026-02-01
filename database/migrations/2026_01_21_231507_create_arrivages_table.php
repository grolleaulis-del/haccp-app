<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arrivages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->cascadeOnDelete();
            $table->date('date_arrivage');
            $table->string('bl_path')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->index(['date_arrivage', 'fournisseur_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('arrivages');
    }
};
