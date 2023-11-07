<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
create definer = root@localhost trigger tr_insertar_boletos
    after insert
    on evento_zona
    for each row
BEGIN
    DECLARE id_zona_actual INT;
    DECLARE id_evento_actual INT;
    DECLARE fecha_evento_actual DATETIME;

    SET id_zona_actual = NEW.id_zona;
    SET id_evento_actual = NEW.id_evento;
    SET fecha_evento_actual = (SELECT fecha FROM evento WHERE id = id_evento_actual);


     INSERT INTO boleto (fecha, id_evento_zona, id_asiento, leido, reservado)
    SELECT fecha_evento_actual, NEW.id, id, 0, 0
    FROM asientos
    WHERE id_zona = id_zona_actual;
END;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_insertar_boletos');
    }
};
