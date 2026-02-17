<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('familles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('description')->nullable();
            $table->string('emoji', 10)->nullable();
            $table->timestamps();
        });

        // Seed existing families from produits table
        $existingFamilles = DB::table('produits')
            ->select('famille')
            ->distinct()
            ->whereNotNull('famille')
            ->where('famille', '!=', '')
            ->pluck('famille');

        foreach ($existingFamilles as $famille) {
            DB::table('familles')->insert([
                'nom' => $famille,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('familles');
    }
};
