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
        Schema::create('reservas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('dui');
            $table->string('telefono', 10);
            $table->string('email', 100);
            $table->tinyInteger('estado')->default(1);
            $table->tinyInteger('leido');
            $table->integer('id_usuario')->nullable()->index('reservas_usuarios_id_usuario_fk');
            $table->integer('id_boleto')->index('reservas_boletos_id_boleto_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
