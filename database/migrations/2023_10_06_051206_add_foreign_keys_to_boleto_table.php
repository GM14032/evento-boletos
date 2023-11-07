<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boleto', function (Blueprint $table) {
            $table->foreign(['id_asiento'], 'boleto_asiento_id_evento_fk')->references(['id'])->on('asientos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_evento_zona'], 'boleto_evento_id_evento_fk')->references(['id'])->on('evento_zona')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boleto', function (Blueprint $table) {
            $table->dropForeign('boleto_asiento_id_evento_fk');
            $table->dropForeign('boleto_evento_id_evento_fk');
        });
    }
};
