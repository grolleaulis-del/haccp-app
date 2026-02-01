<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lots_utilisation', function (Blueprint $table) {
            $table->string('type_operation')->default('usage')->after('user_id'); // usage, cuisson, congelation
            $table->integer('quantite')->nullable()->after('type_operation');
            $table->date('date_production')->nullable()->after('quantite');
            $table->date('dlc')->nullable()->after('date_production');
            $table->decimal('temperature_cuisson', 5, 1)->nullable()->after('dlc');
            $table->decimal('temperature_refroidissement', 5, 1)->nullable()->after('temperature_cuisson');
            $table->text('observations')->nullable()->after('temperature_refroidissement');
        });
    }

    public function down(): void
    {
        Schema::table('lots_utilisation', function (Blueprint $table) {
            $table->dropColumn([
                'type_operation',
                'quantite',
                'date_production',
                'dlc',
                'temperature_cuisson',
                'temperature_refroidissement',
                'observations'
            ]);
        });
    }
};
