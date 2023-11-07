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
        Schema::create('boleto', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('fecha');
            $table->integer('id_evento_zona')->index('boleto_evento_id_evento_fk');
            $table->integer('id_asiento')->index('boleto_asiento_id_evento_fk');
            $table->boolean('leido');
            $table->boolean('reservado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boleto');
    }
};
