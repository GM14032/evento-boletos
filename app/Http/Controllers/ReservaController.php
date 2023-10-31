<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index()
    {
        $zonaId = 3;
        $event = Evento::find($zonaId);

        $zonas = Evento::join('evento_zona', 'evento.id', '=', 'evento_zona.id_evento')
            ->join('zonas', 'evento_zona.id_zona', '=', 'zonas.id')
            ->where('evento.id', '=', $zonaId)
            ->select('zonas.*', 'evento_zona.precio')
            ->get();
        return view('reservas', compact('event','zonas'));
    }
    public function obtenerFila($id) {
        $fila = DB::table('boleto')
            ->join('asientos', 'boleto.id_asiento', '=', 'asientos.id')
            ->join('evento_zona', 'boleto.id_evento_zona', '=', 'evento_zona.id')
            ->where('boleto.id_evento_zona', '=', $id)
            ->where('boleto.reservado', '=', 0)
            ->groupBy('asientos.fila','boleto.id_evento_zona')
            ->select('asientos.fila','boleto.id_evento_zona')
            ->get();
        return response()->json($fila);
    }
    public function obtenerAsiento($id, $fila) {
         //select a.*,b.id_evento_zona,b.reservado from boleto as b inner join asientos as a on b.id_asiento = a.id
        //                  inner join evento_zona as az on b.id_evento_zona = az.id  where b.id_evento_zona =1}
        $asiento = DB::table('boleto')
            ->join('asientos', 'boleto.id_asiento', '=', 'asientos.id')
            ->join('evento_zona', 'boleto.id_evento_zona', '=', 'evento_zona.id')
            ->where('boleto.id_evento_zona', '=', $id)
            ->where('boleto.reservado', '=', 0)
            ->where('asientos.fila', '=', $fila)
            ->select('asientos.*','boleto.id_evento_zona','boleto.reservado')
            ->get();
        return response()->json($asiento);
    }

    public function obtenerAsientosPorEventoYZona($idEvent, $idZona){
        $asientos = DB::table('boleto')
            ->join('asientos', 'boleto.id_asiento', '=', 'asientos.id')
            ->join('evento_zona', 'boleto.id_evento_zona', '=', 'evento_zona.id')
            ->where('evento_zona.id_evento', '=', $idEvent)
            ->where('evento_zona.id_zona', '=', $idZona)
            ->select('asientos.*', 'evento_zona.precio', 'boleto.id','boleto.id_evento_zona','boleto.reservado')
            ->get();
        return response()->json($asientos);
    }

}
