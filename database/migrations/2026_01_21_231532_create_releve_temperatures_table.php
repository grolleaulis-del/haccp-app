<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('releves_temperature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipement_temperature_id')
                ->constrained('equipements_temperature')->restrictOnDelete();

            $table->decimal('temperature', 4, 1);
            $table->boolean('conforme')->default(true);
            $table->text('action_corrective')->nullable();

            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();

            $table->timestamps();

            $table->index(['equipement_temperature_id', 'created_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('releve_temperatures');
    }
};
