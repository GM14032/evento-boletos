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
        Schema::create('evento_zona', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_evento')->index('evento_zona_id_evento_fk');
            $table->integer('id_zona')->index('evento_zona_id_zona_fk');
            $table->decimal('precio', 10, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_zona');
    }
};
