<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Reserva;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservaController extends Controller
{
    public function index($id)
    {
        $event = Evento::find($id);
        $zonas = DB::table('evento_zona')
            ->join('zonas', 'evento_zona.id_zona', '=', 'zonas.id')
            ->join('evento', 'evento_zona.id_evento', '=', 'evento.id')
            ->where('evento.id', '=', 1)
            ->select('evento_zona.id', 'zonas.nombre', 'evento_zona.precio', 'evento.fecha')
            ->get();
        return view('reservas', compact('event','zonas'));
    }

    public function generarQr($request,$evento)
    {
        $event=$evento[0];
        $reservas = $request->reservas;
        $qrCodes = [];
        foreach ($reservas as $reserva) {
            $qrContent = json_encode([
                'dui' => $request['dui'],
                'id_boleto' => $reserva['id_boleto'],
                'email' => $request['email'],
                'telefono' => $request['telefono'],
                'evento' => $event->evento,
                'fila' => $reserva['fila'],
                'asiento' => $reserva['numero'],
            ]);

            $qrCode = QrCode::size(200)->generate($qrContent);
            $qrCodes[] = base64_encode($qrCode);
        }
        $pdf = PDF::loadView('qr', compact('qrCodes', 'reservas','event'));
        $pdf->setPaper('A4', 'landscape');
        $this->enviarEmail($pdf, $request['email']);
    }
    public function enviarEmail($pdf, $email)
    {
        Mail::send([], [], function ($message) use ($pdf, $email) {
            $message->to($email)
                ->subject('Boletos para concierto')
                ->attachData($pdf->output(), 'reservas.pdf');
        });
    }

    public function obtenerFila( $idZona){
        $filas = DB::table('asientos')
            ->join('evento_zona', 'asientos.id_zona', '=', 'evento_zona.id')
            ->join('boleto', 'asientos.id', '=', 'boleto.id_asiento')
            ->where('evento_zona.id', '=', $idZona)
            ->where('boleto.reservado', '=', 0)
            ->select('asientos.fila')
            ->distinct()
            ->get();
        return response()->json($filas);
    }
    public function obtenerAsiento($idZona,$fila){
                 $asientos = DB::table('asientos')
            ->join('evento_zona', 'asientos.id_zona', '=', 'evento_zona.id')
            ->join('boleto', 'asientos.id', '=', 'boleto.id_asiento')
            ->where('evento_zona.id', '=', $idZona)
            ->where('boleto.reservado', '=', 0)
            ->where('asientos.fila', '=', $fila)
            ->select('asientos.numero', 'boleto.id')
            ->distinct()
            ->get();

        return response()->json($asientos);
    }
    public function guardarReserva(Request $request){
        $reservas = $request->reservas;

        $evento= DB::table('evento')
            ->join('evento_zona', 'evento.id', '=', 'evento_zona.id_evento')
            ->join('zonas', 'evento_zona.id_zona', '=', 'zonas.id')
            ->where('evento_zona.id', '=', $reservas[0]['id_zona'])
            ->select('evento.evento', 'evento.ruta_imagen', 'zonas.nombre','evento_zona.precio')
            ->get();

       foreach ($request->reservas as $reservaData) {
            $reserva = new Reserva();
            $reserva->dui = $request->dui;
            $reserva->telefono = $request->telefono;
            $reserva->email = $request->email;
            $reserva->id_boleto=$reservaData['id_boleto'];
            $reserva->leido=0;
            $reserva->save();
            DB::table('boleto')
                ->where('id', '=', $reservaData['id_boleto'])
                ->update(['reservado' => 1]);

        }
        $this->generarQr($request,$evento);
        return response()->json(['message' => 'Reserva creada con éxito'], 201);
    }

    public function obtenerAsientoPorZona($idZonaEvento){
        $asientos = DB::table('asientos')
            ->join('evento_zona', 'asientos.id_zona', '=', 'evento_zona.id')
            ->join('boleto', 'asientos.id', '=', 'boleto.id_asiento')
            ->where('evento_zona.id', '=', $idZonaEvento)
            ->where('boleto.reservado', '=', 0)
            ->select('asientos.numero','asientos.fila', 'boleto.id')
            ->distinct()
            ->get();
        return response()->json($asientos);
    }
}
