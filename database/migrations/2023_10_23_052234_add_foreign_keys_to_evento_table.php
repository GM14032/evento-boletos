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
        Schema::table('evento', function (Blueprint $table) {
            $table->foreign(['id_formato'], 'evento_formato_id_formato_fk')->references(['id'])->on('formato')->onUpdate('NO ACTION')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento', function (Blueprint $table) {
            $table->dropForeign('evento_formato_id_formato_fk');

        });
    }
};
