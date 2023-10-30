<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Asiento;

class AsientoController extends Controller
{
    public function cargarAsientos(Request $request)
    {
        $id_zona = $request->id_zona;
        //obtener todos los asientos de la zona
        $asientos = Asiento::where('id_zona', $id_zona)->get();
        return response()->json($asientos);
    }
}
