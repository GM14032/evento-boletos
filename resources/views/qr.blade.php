<!DOCTYPE html>
<html>
<head>
    <title>Códigos QR</title>
</head>
<body>
@foreach ($reservas as $key => $reserva)
    <div class="row">
        <div class="col-sm-4">
            <div class="horizontal-content imagen">
                <img src="data:image/png;base64,{{ $qrCodes[$key] }}" alt="Imagen del Evento" width="25%">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="horizontal-content">
                <table>
                    <tr>
                        <th>Nombre del Evento</th>
                        <td>{{$event->evento}}</td>
                    </tr>
                    <tr>
                        <th>Zona y Precio</th>
                        <td>{{$event->nombre}} - {{$event->precio}}</td>
                    </tr>
                    <tr>
                        <th>Asiento</th>
                        <td>{{$reserva['fila']}}-{{$reserva['numero']}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
@endforeach
</body>
</html>

