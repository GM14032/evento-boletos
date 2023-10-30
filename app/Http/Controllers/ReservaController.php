<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index()
    {
        $event = Evento::find(3);

        $zonas = Evento::join('evento_zona', 'evento.id', '=', 'evento_zona.id_evento')
            ->join('zonas', 'evento_zona.id_zona', '=', 'zonas.id')
            ->where('evento.id', '=', 3)
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
         $asiento = DB::table('boleto')
            ->join('asientos', 'boleto.id_asiento', '=', 'asientos.id')
            ->join('evento_zona', 'boleto.id_evento_zona', '=', 'evento_zona.id')
            ->where('boleto.id_evento_zona', '=', $id)
            ->where('boleto.reservado', '=', 0)
            ->where('asientos.fila', '=', $fila)
            ->select('asientos.numero','boleto.id')
            ->get();
        return response()->json($asiento);
    }

}
