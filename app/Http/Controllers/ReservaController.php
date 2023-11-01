<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Swift_Message;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;

class ReservaController extends Controller
{
    public function index()
    {

        $event = Evento::find(1);
      //  $this->generarQr();
        $zonas = DB::table('evento_zona')
            ->join('zonas', 'evento_zona.id_zona', '=', 'zonas.id')
            ->join('evento', 'evento_zona.id_evento', '=', 'evento.id')
            ->where('evento.id', '=', 1)
            ->select('evento_zona.id', 'zonas.nombre', 'evento_zona.precio', 'evento.fecha')
            ->get();
        return view('reservas', compact('event','zonas'));
    }

    public function generarQr()
    {
        $idReserva = 1;
        $idEvento = 3;
        $idZona = 1;
        $idUsuario = 1;
        $qrContent = json_encode([
            'id_reserva' => $idReserva,
            'id_evento' => $idEvento,
            'id_zona' => $idZona,
            'id_usuario' => $idUsuario,
        ]);
       // $qrCode = QrCode::format('png')->size(200)->generate($qrContent);
        $qrCode=QrCode::size(100)->generate($qrContent);

        $pdf = PDF::loadView('qr', compact('qrCode'));
        //$pdf = PDF::loadView('qr');
    // $pdf->getDomPDF()->getCanvas()->image($qrCodePath, 50, 50, 100, 100);
       // $pdfPath = public_path('/reserva.pdf');
        //$pdf->save($pdfPath);
      /*  Mail::send([], [], function ($message) use ($pdf) {
            $message->from('fiebre.libros@gmail.com');
            $message->subject('Asunto del correo');
            $message->setBody(new TextPart('Este es el cuerpo del correo electrónico en texto simple.'));
           // $message->attachFromPath($pdf);
            $message->attachStream($pdf->output(), 'reserva.pdf');

            $message->to('fiebre.libros@gmail.com');
        });*/
        Mail::send('qr', [], function ($message) use ($pdf) {
            $message->to('fiebre.libros@gmail.com')
                ->subject('Asunto del correo')
                ->attachData($pdf->output(), 'reserva.pdf');
        });

        //unlink($qrCodePath);
       // unlink($pdfPath);
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
            ->select('asientos.numero', 'asientos.id')
            ->distinct()
            ->get();
        return response()->json($asientos);
    }
    public function guardarReserva(Request $request){

    }

    public function obtenerAsientoPorZona($idZonaEvento){
        $asientos = DB::table('asientos')
            ->join('evento_zona', 'asientos.id_zona', '=', 'evento_zona.id')
            ->join('boleto', 'asientos.id', '=', 'boleto.id_asiento')
            ->where('evento_zona.id', '=', $idZonaEvento)
            ->where('boleto.reservado', '=', 0)
            ->select('asientos.numero','asientos.fila', 'asientos.id')
            ->distinct()
            ->get();
        return response()->json($asientos);
    }
}
